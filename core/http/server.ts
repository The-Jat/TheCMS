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

export class HttpServer {
    private app = express();

    constructor(
        private routeRegistry: RouteRegistry,
        private pluginLoader: any,
        private admin: PluginAdminService,
        private pipelineEngine: RequestPipelineEngine,
        private container: Container,
    ) { }

    init() {
        this.app.use(express.json());

        this.app.use(
            session({
                secret: 'super-secret-key',
                resave: false,
                saveUninitialized: false,
                cookie: {
                    httpOnly: true,
                    secure: false,
                },
            }),
        );

        this.app.get(
            '/admin/me',
            (req: any, res) => {
                res.json(req.user);
            }
        );

        this.app.get(
            '/admin/login',
            (req, res) => {

                const oauth =
                    this.container.get('oauth');

                const auth =
                    oauth.getAuthorizationUrl();

                req.session.oauthState =
                    auth.state;

                req.session.codeVerifier =
                    auth.verifier;

                return res.redirect(auth.url);
            }
        );

        // auth callback route
        this.app.get(
            '/admin/callback',
            async (req, res) => {

                const code = req.query.code;
                const verifier = req.session.codeVerifier;
                const oauth = this.container.get('oauth');
                const token = await oauth.exchangeCode(code as string, verifier);

                res.cookie(
                    'access_token',
                    token.access_token,
                    {
                        httpOnly: true,
                        sameSite: 'lax',
                    }
                );
                res.cookie(
                    'refresh_token',
                    token.refresh_token,
                    {
                        httpOnly: true,
                        sameSite: 'lax',
                    }
                );

                return res.redirect('/admin');
            }
        );

        this.app.use(cookieParser());

        const oauth = this.container.get('oauth');

        const adminAuth = new AdminAuthMiddleware(oauth);
        // protected route
        this.app.get(
            '/admin',
            adminAuth.handle.bind(adminAuth),
            (req: any, res) => {

                res.send(
                    `Welcome ${req.user.name}`,
                );
            },
        );

        // admin routes
        this.app.get('/admin/plugins', adminAuth.handle.bind(adminAuth),
            (req, res) => {
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