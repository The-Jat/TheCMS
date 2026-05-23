import { PermissionService } from './permission.service';

export class AuthorizationGate {

    constructor(
        private permissions: PermissionService,
    ) { }

    authorize(user: any, route: any): boolean {

        // public route
        if (!route.permission) {
            return true;
        }

        // protected route
        return this.permissions.hasPermission(
            user,
            route.permission
        );
    }
}