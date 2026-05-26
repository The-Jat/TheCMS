// core/admin/admin-manifest.service.ts

import { PluginLoader } from '../plugin-loader';

export class AdminManifestService {

  constructor(
    private loader: PluginLoader,
  ) {}

  getManifest() {

    const plugins =
      this.loader.getPlugins();

    const navigation: any[] = [];

    const routes: any[] = [];

    const pluginEntries: any[] = [];

    for (const item of plugins) {

      const plugin = item.plugin;

      if (!plugin.admin) {
        continue;
      }

      pluginEntries.push({
        name: plugin.name,
        entry: plugin.admin.entry,
      });

      navigation.push(
        ...(plugin.admin.navigation ?? [])
      );

      for (const route of (plugin.admin.routes ?? [])) {

        routes.push({
          ...route,
          plugin: plugin.name,
        });
      }
    }

    return {
      app: {
        name: 'TheCMS',
      },

      theme: {
        name: 'default',
      },

      plugins: pluginEntries,

      navigation,

      routes,
    };
  }
}