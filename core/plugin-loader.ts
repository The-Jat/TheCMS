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
    const pluginsDir = path.join(
      process.cwd(),
      'plugins',
    );

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
        console.log(
          `Skipping ${pluginName}: plugin.json missing`,
        );

        continue;
      }

      const manifest = JSON.parse(
        fs.readFileSync(manifestPath, 'utf-8'),
      );

      const entryPath = path.join(
        pluginsDir,
        pluginName,
        manifest.entry,
      );

      const pluginModule = await import(
        pathToFileURL(entryPath).href
      );

      const plugin = pluginModule.default;

      await this.hooks.emit(`plugin.loaded`, plugin);

      console.log('PLUGIN');
      console.log(plugin);

      this.routeRegistry.register(
        plugin.routes ?? [],
      );

      this.permissionRegistry.register(
        plugin.permissions ?? [],
      );

      this.adminRegistry.register(
        plugin.adminNavigation ?? [],
      );

      if (!manifest.enabled) {
        console.log(
          `Skipping ${manifest.name}: disabled`,
        );

        continue;
      }

      console.log('PLUGIN MANIFEST');
      console.log(manifest);
    }
  }
}