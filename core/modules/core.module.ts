// core/modules/core.module.ts

import { OAuthService } from "../../modules/auth/oauth.service";
import { AdminPageRegistry } from "../admin/admin-page.registry";
import { Container } from "../container";
import { HookSystem } from "../hooks";
import { AdminRegistry } from "../registry/admin.registry";
import { PermissionRegistry } from "../registry/permission.registry";
import { RouteRegistry } from "../registry/route.registry";

export class CoreModule {
    async register(container: Container) {

        container.register(
            'hooks',
            new HookSystem()
        );

        container.register(
            'routeRegistry',
            new RouteRegistry()
        );

        container.register(
            'permissionRegistry',
            new PermissionRegistry()
        );

        container.register(
            'adminRegistry',
            new AdminRegistry()
        );

        container.register(
            'adminPageRegistry',
            new AdminPageRegistry(),
        );
    }
}