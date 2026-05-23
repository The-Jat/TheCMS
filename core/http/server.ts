import express from 'express';
import { RouteRegistry } from '../registry/route.registry';
import { MiddlewarePipeline } from './middleware';
import { RequestContext } from './request-context';
import { PermissionService } from '../auth/permission.service';
import { PluginAdminService } from '../admin/plugin-admin.service';
import { RequestPipelineEngine } from './request-pipeline.engine';

export class HttpServer {
    private app = express();

    constructor(
        private routeRegistry: RouteRegistry,
        private pluginLoader: any,
        private admin: PluginAdminService,
        private pipelineEngine: RequestPipelineEngine,
    ) { }

    init() {
        this.app.use(express.json());

        // admin routes
        this.app.get('/admin/plugins', (req, res) => {
            res.json(this.admin.getPlugins());
        });

        this.app.get('/admin/plugins/:name', (req, res) => {
            const data = this.admin.getPluginDetails(req.params.name);

            if (!data) return res.status(404).json({ error: 'Not found' });

            res.json(data);
        });

         // single catch all route
        this.app.use(async (req, res, next) => {
            try {
                await this.pipelineEngine.execute(req, res);
            } catch (err) {
                next(err);
            }
        });

        this.app.use((err, req, res, next) => {
            console.error(err);

            res.status(500).json({
                error: 'Internal Server Error'
            });
        });

        return this.app;
    }

    listen(port: number) {
        this.app.listen(port, () => {
            console.log(`🚀 CMS running on http://localhost:${port}`);
        });
    }
}