import fs from 'fs';
import path from 'path';
import { pathToFileURL } from 'url';
import { RouteRegistry } from './registry/route.registry';
import { PermissionRegistry } from './registry/permission.registry';
import { AdminRegistry } from './registry/admin.registry';

import { HookSystem } from './hooks';

export class PluginLoader {
  constructor(
    private readonly routeRegistry: RouteRegistry,
    private readonly permissionRegistry: PermissionRegistry,
    private readonly adminRegistry: AdminRegistry,
    private readonly hooks: HookSystem,
  ) {}
  async discover() {
    const pluginsDir = path.join(process.cwd(), 'plugins');

    if (!fs.existsSync(pluginsDir)) {
      console.log('Plugins directory not found');
      return [];
    }

    const dirs = fs.readdirSync(pluginsDir);

    // PHASE 1: collect manifests
    const manifests: Record<string, any> = {};

    for (const pluginName of dirs) {
      const manifestPath = path.join(
        pluginsDir,
        pluginName,
        'plugin.json',
      );

      if (!fs.existsSync(manifestPath)) continue;

      const manifest = JSON.parse(
        fs.readFileSync(manifestPath, 'utf-8'),
      );

      manifests[manifest.name] = {
        ...manifest,
        pluginName,
      };
    }

    // PHASE 2: sort by dependencies
    const order = this.sortPlugins(manifests);

    // PHASE 3: load plugins in order
    for (const name of order) {
      const manifest = manifests[name];

      if (!manifest) continue;

      await this.hooks.emit('plugin.beforeLoad', manifest);

      if (!manifest.enabled) {
        console.log(`Skipping ${manifest.name}: disabled`);
        continue;
      }

      const entryPath = path.join(
        pluginsDir,
        manifest.pluginName,
        manifest.entry,
      );

      const pluginModule = await import(
        pathToFileURL(entryPath).href
      );

      const plugin = pluginModule.default;

      await this.hooks.emit('plugin.loaded', plugin);

      this.routeRegistry.register(plugin.routes ?? []);
      this.permissionRegistry.register(plugin.permissions ?? []);
      this.adminRegistry.register(plugin.adminNavigation ?? []);

      await this.hooks.emit('plugin.afterLoad', plugin);
    }
  }

  private sortPlugins(manifests: Record<string, any>) {
    const sorted: string[] = [];
    const visited = new Set<string>();

    const visit = (name: string) => {
      if (visited.has(name)) return;

      const plugin = manifests[name];
      if (!plugin) return;

      visited.add(name);

      const deps = plugin.dependencies || [];

      for (const dep of deps) {
        visit(dep);
      }

      sorted.push(name);
    };

    for (const name of Object.keys(manifests)) {
      visit(name);
    }

    return sorted;
  }
}