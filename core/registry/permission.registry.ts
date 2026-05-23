export class PermissionRegistry {
  private permissions: string[] = [];

  register(permissions: string[]) {
    this.permissions.push(...permissions);
  }

  getAll() {
    return this.permissions;
  }
}