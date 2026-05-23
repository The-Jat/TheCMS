import { RouteDefinition } from '@thejatcms/sdk';

export class RouteRegistry {
  private routes: RouteDefinition[] = [];

  private pluginRoutes = new Map<string, RouteDefinition[]>();

  register(routes: RouteDefinition[], pluginName = 'global') {
    this.routes.push(...routes);

    const existing = this.pluginRoutes.get(pluginName) || [];
    this.pluginRoutes.set(pluginName, [...existing, ...routes]);
  }

  unregister(pluginName: string) {
    const pluginRoutes = this.pluginRoutes.get(pluginName);

    if (!pluginRoutes) return;

    // remove plugin routes from global list
    this.routes = this.routes.filter(
      r => !pluginRoutes.includes(r)
    );

    this.pluginRoutes.delete(pluginName);
  }

  replace(routes: RouteDefinition[], pluginName: string) {
    this.unregister(pluginName);
    this.register(routes, pluginName);
  }

  getAll() {
    return this.routes;
  }
}