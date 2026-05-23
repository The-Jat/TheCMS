import express from 'express';
import { RouteRegistry } from '../registry/route.registry';
import { MiddlewarePipeline } from './middleware';
import { RequestContext } from './request-context';
import { PermissionService } from '../auth/permission.service';
import { PluginAdminService } from '../admin/plugin-admin.service';
import { HookSystem } from '../hooks';

export class RequestPipelineEngine {
    constructor(
        private routeRegistry: RouteRegistry,
        private pluginLoader: any,
        private auth: PermissionService,
        private hooks: HookSystem,
        private middleware: MiddlewarePipeline,
    ) { }

    async execute(req: any, res: any) {

        // execute global middleware
        await this.middleware.execute(req, res);

        let routeDef: any = null;

        for (const route of this.routeRegistry.getAll()) {

            if (
                route.method.toUpperCase() !==
                req.method.toUpperCase()
            ) {
                continue;
            }

            const matched = route.matcher(req.path);

            if (matched) {
                routeDef = route;

                req.params = matched.params;

                break;
            }
        }
        if (!routeDef) {
            res.status(404).json({ error: 'Route not found' });
            return;
        }

        // permission check
        if (routeDef.permission) {
            const allowed = this.auth.hasPermission(
                req.user,
                routeDef.permission
            );

            if (!allowed) {
                return res.status(403).json({
                    error: 'Forbidden'
                });
            }
        }

        const plugin = this.pluginLoader
            .getPlugins()
            .find((p: any) => p.plugin.name === routeDef.pluginName)
            ?.plugin;

        if (!plugin) {
            res.status(500).json({ error: 'Plugin not found' });
            return;
        }

        await this.hooks.emit('handler.before', {
            req,
            res,
            route: routeDef,
        });

        const handler = plugin.handlers?.[routeDef.handler];

        if (!handler) {
            res.status(500).json({ error: 'Handler missing' });
            return;
        }

        const ctx = new RequestContext(req, res, plugin, req.user);

        const result = await handler(ctx);

        await this.hooks.emit('handler.after', {
            req,
            res,
            route: routeDef,
            result,
        });

        return this.normalizeResponse(res, result);
    }

    private normalizeResponse(res: any, result: any) {
        if (res.headersSent) return;

        // Option A behavior support
        if (result?.type === 'json') {
            return res.json(result.data);
        }

        if (result?.type === 'status') {
            return res.status(result.code).end();
        }

        // default behavior
        return res.json(result);
    }
}