import express from 'express';
import { RouteRegistry } from '../registry/route.registry';
import { MiddlewarePipeline } from './middleware';
import { RequestContext } from './request-context';
import { PermissionService } from '../auth/permission.service';

export class HttpServer {
    private app = express();
    private pipeline = new MiddlewarePipeline();
    private auth = new PermissionService();

    constructor(
        private routeRegistry: RouteRegistry,
        private pluginLoader: any,
    ) { }

    init() {
        this.app.use(express.json());

        // attach routes dynamically
        this.bindRoutes();

        // Register middleware
        this.pipeline.use(async (req, res, next) => {
            console.log(`Incoming: ${req.method} ${req.path}`);
            req.user = {
                id: 1,
                name: 'TheJat',
                permissions: ['blog.read'], // mock user permissions
            };
            next();
        });

        return this.app;
    }

    private bindRoutes() {
        const routes = this.routeRegistry.getAll();

        for (const route of routes) {
            this.app[route.method.toLowerCase() as any](
                route.path,
                async (req, res) => {

                    await this.pipeline.run(req, res);

                    const plugin = this.findPluginForRoute(route.path);

                    if (!plugin) {
                        return res.status(404).json({ error: 'Plugin not found' });
                    }

                    const handlerName = (route as any).handler;
                    const handler = plugin.handlers?.[handlerName];

                    if (!handler) {
                        return res.status(500).json({ error: 'Handler missing' });
                    }

                    const user = req.user || null;

                    // 🔐 FIND ROUTE DEFINITION
                    const routeDef = plugin.routes.find(
                        (r: any) => r.path === route.path
                    );

                    // 🔐 PERMISSION CHECK
                    if (!this.auth.hasPermission(user, routeDef?.permission)) {
                        return res.status(403).json({ error: 'Forbidden' });
                    }

                    const ctx = new RequestContext(req, res, plugin, user);

                    return handler(ctx);
                }
            );
        }
    }
    listen(port: number) {
        this.app.listen(port, () => {
            console.log(`🚀 CMS running on http://localhost:${port}`);
        });
    }

    private findPluginForRoute(path: string) {
        return this.pluginLoader.getPlugins?.().find((p: any) =>
            p.plugin.routes?.some((r: any) => r.path === path)
        )?.plugin;
    }
}