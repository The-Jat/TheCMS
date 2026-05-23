export class PermissionService {
  hasPermission(user: any, permission?: string) {
    if (!permission) return true;
    if (!user) return false;

    return user.permissions?.includes(permission);
  }
}