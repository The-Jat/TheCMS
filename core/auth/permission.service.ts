export class PermissionService {
  hasPermission(user: any, permission?: string): boolean {
    if (!permission) return true;
    if (!user) return false;

    return user.permissions?.includes(permission);
  }

  hasAny(user: any, permissions: string[] = []): boolean {
    return permissions.some((p) =>
      user.permissions?.includes(p)
    );
  }

  hasAll(user: any, permissions: string[] = []): boolean {
    return permissions.every((p) =>
      user.permissions?.includes(p)
    );
  }
}