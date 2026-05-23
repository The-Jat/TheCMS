import express from 'express';
import { RouteRegistry } from '../registry/route.registry';

export class HttpServer {
  private app = express();

  constructor(
    private routeRegistry: RouteRegistry,
    private pluginLoader: any,
) {}

  init() {
    this.app.use(express.json());

    // attach routes dynamically
    this.bindRoutes();

    return this.app;
  }

    private bindRoutes() {
        const routes = this.routeRegistry.getAll();

        for (const route of routes) {
            this.app[route.method.toLowerCase() as any](
                route.path,
                async (req, res) => {
                    const plugin = this.findPluginForRoute(route.path);

                    if (!plugin) {
                        return res.status(404).json({ error: 'Plugin not found' });
                    }

                    const handlerName = (route as any).handler;
                    const handler = plugin.handlers?.[handlerName];

                    if (!handler) {
                        return res.status(500).json({ error: 'Handler missing' });
                    }

                    return handler(req, res);
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