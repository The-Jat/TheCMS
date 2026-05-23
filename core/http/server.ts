import express from 'express';
import { RouteRegistry } from '../registry/route.registry';

export class HttpServer {
  private app = express();

  constructor(private routeRegistry: RouteRegistry) {}

  init() {
    this.app.use(express.json());

    // attach routes dynamically
    this.bindRoutes();

    return this.app;
  }

  private bindRoutes() {
    const routes = this.routeRegistry.getAll();

    for (const route of routes) {
      this.app[route.method.toLowerCase() as 'get' | 'post' | 'put' | 'patch' | 'delete'](
        route.path,
        async (req, res) => {
          res.json({
            message: `Route hit: ${route.path}`,
          });
        }
      );
    }
  }

  listen(port: number) {
    this.app.listen(port, () => {
      console.log(`🚀 CMS running on http://localhost:${port}`);
    });
  }
}