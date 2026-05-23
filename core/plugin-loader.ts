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

    const plugins = fs.readdirSync(pluginsDir);

    for (const pluginName of plugins) {
      const manifestPath = path.join(
        pluginsDir,
        pluginName,
        'plugin.json',
      );

      if (!fs.existsSync(manifestPath)) {
        console.log(`Skipping ${pluginName}: plugin.json missing`);
        continue;
      }

      // 1. LOAD MANIFEST FIRST
      const manifest = JSON.parse(
        fs.readFileSync(manifestPath, 'utf-8'),
      );

      // 2. BEFORE LOAD HOOK
      await this.hooks.emit('plugin.beforeLoad', manifest);

      // 3. CHECK ENABLED BEFORE DOING ANYTHING
      if (!manifest.enabled) {
        console.log(`Skipping ${manifest.name}: disabled`);
        continue;
      }

      // 4. RESOLVE ENTRY
      const entryPath = path.join(
        pluginsDir,
        pluginName,
        manifest.entry,
      );

      // 5. LOAD PLUGIN
      const pluginModule = await import(
        pathToFileURL(entryPath).href
      );

      const plugin = pluginModule.default;

      // 6. LOADED HOOK
      await this.hooks.emit('plugin.loaded', plugin);

      console.log('PLUGIN');
      console.log(plugin);

      // 7. REGISTER INTO KERNEL
      this.routeRegistry.register(plugin.routes ?? []);
      this.permissionRegistry.register(plugin.permissions ?? []);
      this.adminRegistry.register(plugin.adminNavigation ?? []);

      // 8. AFTER LOAD HOOK
      await this.hooks.emit('plugin.afterLoad', plugin);

      // 9. DEBUG OUTPUT
      console.log('PLUGIN MANIFEST');
      console.log(manifest);
    }
  }
}