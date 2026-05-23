import express from 'express';
import { RouteRegistry } from '../registry/route.registry';
import { MiddlewarePipeline } from './middleware';
import { RequestContext } from './request-context';
import { PermissionService } from '../auth/permission.service';
import { PluginAdminService } from '../admin/plugin-admin.service';

export class HttpServer {
    private app = express();
    private pipeline = new MiddlewarePipeline();
    private auth = new PermissionService();

    constructor(
        private routeRegistry: RouteRegistry,
        private pluginLoader: any,
        private admin: PluginAdminService,
    ) { }

    init() {
        this.app.use(express.json());

        // register middleware first
        this.pipeline.use(async (req, res, next) => {
            console.log(`Incoming: ${req.method} ${req.path}`);
            // Modifying the request attaching info
            req.user = {
                id: 1,
                name: 'TheJat',
                permissions: ['blog.read'], // mock user permissions
            };
            next();
        });

        // bind routes
        this.bindRoutes();

        return this.app;
    }

    private bindRoutes() {
        const routes = this.routeRegistry.getAll();

        for (const route of routes) {
            this.app[route.method.toLowerCase() as any](
                route.path,
                async (req, res) => {
                    await this.pluginLoader.hooks.emit('request.before', { req, res });

                    // middleware execution
                    await this.pipeline.execute(req, res);

                    const routeDef = this.routeRegistry
                        .getAll()
                        .find(
                            (r: any) =>
                                r.method === req.method &&
                                r.path === req.path
                        );

                    if (!routeDef) {
                        return res.status(404).json({ error: 'Route not found' });
                    }

                    // permission check
                    if (routeDef.permission) {
                        const allowed = this.auth.hasPermission(
                            req.user,
                            routeDef.permission
                        );

                        if (!allowed) {
                            return res.status(403).json({ error: 'Forbidden' });
                        }
                    }

                    // plugin resolution
                    const plugin = this.pluginLoader
                        .getPlugins()
                        .find(
                            (p: any) =>
                                p.plugin.name === routeDef.pluginName
                        )?.plugin;

                    if (!plugin) {
                        return res.status(500).json({ error: 'Plugin not found' });
                    }

                    await this.pluginLoader.hooks.emit('handler.before', {
                        req,
                        res,
                        route: routeDef,
                    });

                    // handler execution
                    const handler = plugin.handlers?.[routeDef.handler];

                    if (!handler) {
                        return res.status(500).json({ error: 'Handler missing' });
                    }

                    const ctx = new RequestContext(req, res);

                    const result = await handler(ctx);

                    // safety check
                    if (res.headersSent) return;

                    // handle undefined
                    if (result === undefined) {
                        return res.end();
                    }

                    // handle structured context response
                    if (result && typeof result === 'object' && '__type' in result) {
                        if (result.__type === 'json') {
                            return res.json(result.data);
                        }

                        if (result.__type === 'status') {
                            return res.status(result.code);
                        }
                    }

                    // fallback
                    await this.pluginLoader.hooks.emit('handler.after', {
                        req,
                        res,
                        route: routeDef,
                        result,
                    });

                    await this.pluginLoader.hooks.emit('request.after', { req, res });

                    return res.json(result);
                }
            );
        }

        this.app.get('/admin/plugins', (req, res) => {
            res.json(this.admin.getPlugins());
        });

        this.app.get('/admin/plugins/:name', (req, res) => {
            const data = this.admin.getPluginDetails(req.params.name);

            if (!data) return res.status(404).json({ error: 'Not found' });

            res.json(data);
        });
    }
    listen(port: number) {
        this.app.listen(port, () => {
            console.log(`🚀 CMS running on http://localhost:${port}`);
        });
    }
}