export class PluginAdminService {
  constructor(private loader: any) {}

  getPlugins() {
    return this.loader.getPlugins().map((p: any) => ({
      name: p.plugin.name,
      version: p.plugin.version,
      enabled: true, // we will improve later with manifest state
    }));
  }

  getPluginDetails(name: string) {
    const plugin = this.loader
      .getPlugins()
      .find((p: any) => p.plugin.name === name);

    if (!plugin) return null;

    return {
      name: plugin.plugin.name,
      routes: plugin.plugin.routes,
      permissions: plugin.plugin.permissions,
      adminNavigation: plugin.plugin.adminNavigation,
    };
  }
}