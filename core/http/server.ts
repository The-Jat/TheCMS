import express from 'express';
import { RouteRegistry } from '../registry/route.registry';
import { MiddlewarePipeline } from './middleware';
import { RequestContext } from './request-context';

export class HttpServer {
    private app = express();
    private pipeline = new MiddlewarePipeline();

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
            req.user = { id: 1, role: 'admin' }; // mock auth
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

                    const ctx = new RequestContext(req, res, plugin);

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