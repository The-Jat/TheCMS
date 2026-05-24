// core/http/server.ts

import express from 'express';
import { RouteRegistry } from '../registry/route.registry';
import { MiddlewarePipeline } from './middleware';
import { RequestContext } from './request-context';
import { PermissionService } from '../auth/permission.service';
import { PluginAdminService } from '../admin/plugin-admin.service';
import { RequestPipelineEngine } from './request-pipeline.engine';
import { Container } from '../container';
import cookieParser from 'cookie-parser';
import { AdminAuthMiddleware } from './admin-auth.middleware';
import session from 'express-session';
import { AdminRoutes } from './routes/admin.routes';
import { AuthRoutes } from './routes/auth.routes';

export class HttpServer {
    private app = express();

    constructor(
        private container: Container,
        private pipelineEngine: RequestPipelineEngine,
    ) { }

    init() {
        this.app.use(express.json());
        this.app.use(cookieParser());

        this.app.use(
            session({
                secret: 'super-secret-key',
                resave: false,
                saveUninitialized: false,
                cookie: {
                    httpOnly: true,
                },
            }),
        );

        // admin routes module
        const adminRoutes = this.container.get('adminRoutes');
        const authRoutes = this.container.get('authRoutes');

        this.app.use('/admin', authRoutes.router);
        this.app.use('/admin', adminRoutes.router);
        
        // plugin pipeline (catch-all)
        // this.app.use((req, res, next) => {
        //     this.pipelineEngine.execute(req, res).catch(next);
        // });
        this.app.use((req, res, next) => {
            if (req.path.startsWith('/admin')) {
                return next(); // let Express handle admin
            }

            this.pipelineEngine.execute(req, res).catch(next);
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