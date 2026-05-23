import { RouteDefinition } from '@thejatcms/sdk';
import { compileRoute } from '../router/route-matcher';

export class RouteRegistry {

    private routes: any[] = [];

    private pluginRoutes = new Map<string, RouteDefinition[]>();

    register(routes: RouteDefinition[], pluginName: string) {

        const enriched = routes.map(r => ({
            ...r,

            pluginName,

            matcher: compileRoute(r.path),
        }));

        this.routes.push(...enriched);

        const existing = this.pluginRoutes.get(pluginName) || [];

        this.pluginRoutes.set(pluginName, [
            ...existing,
            ...routes,
        ]);
    }

    unregister(pluginName: string) {

        const pluginRoutes = this.pluginRoutes.get(pluginName);

        if (!pluginRoutes) return;

        this.routes = this.routes.filter(
            r =>
                !(
                    r.pluginName === pluginName &&
                    pluginRoutes.some(
                        pr =>
                            pr.method === r.method &&
                            pr.path === r.path
                    )
                )
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