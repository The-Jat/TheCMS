import { Permission } from '@thejatcms/sdk';

export class PermissionRegistry {
  private permissions: Permission[] = [];

  register(permissions: Permission[]) {
    this.permissions.push(...permissions);
  }

  getAll() {
    return this.permissions;
  }
}