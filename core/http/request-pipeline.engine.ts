import express from 'express';
import { RouteRegistry } from '../registry/route.registry';
import { MiddlewarePipeline } from './middleware';
import { RequestContext } from './request-context';
import { PermissionService } from '../auth/permission.service';
import { PluginAdminService } from '../admin/plugin-admin.service';
import { HookSystem } from '../hooks';
import { RouteResolver } from '../router/route-resolver';
import { PluginResolver } from '../plugin-resolver';
import { AuthorizationGate } from '../auth/authorization-gate';
import { NotFoundException } from '../exception/not-found.exception';
import { ForbiddenException } from '../exception/forbidden.exception';

export class RequestPipelineEngine {
    constructor(
        private pluginLoader: any,
        private auth: PermissionService,
        private hooks: HookSystem,
        private middleware: MiddlewarePipeline,
        private routeResolver: RouteResolver,
        private pluginResolver: PluginResolver,
        private authGate: AuthorizationGate,
    ) { }

    async execute(req: any, res: any) {

        // execute global middleware
        await this.middleware.execute(req, res);

        const resolved =
            this.routeResolver.resolve(req);

        if (!resolved) {
            throw new NotFoundException('Route not found');
        }

        req.params = resolved.params;

        const route = resolved.route;
        if (!route) {
            throw new NotFoundException('Route not found');
        }

        // permission check
        const authorized =
            this.authGate.authorize(
                req.user,
                route
            );
        if (!authorized) {
            throw new ForbiddenException();
        }

        const plugin =
            this.pluginResolver.resolve(route);

        if (!plugin) {
            res.status(500).json({ error: 'Plugin not found' });
            return;
        }

        await this.hooks.emit('handler.before', {
            req,
            res,
            route: route,
        });

        const handler = plugin.handlers?.[route.handler];

        if (!handler) {
            res.status(500).json({ error: 'Handler missing' });
            return;
        }

        const ctx = new RequestContext(req, res, plugin, req.user);

        const result = await handler(ctx);

        await this.hooks.emit('handler.after', {
            req,
            res,
            route: route,
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