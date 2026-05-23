import { Permission } from "../../packages/sdk/src/plugins";

export class PermissionRegistry {
  private permissions: Permission[] = [];

  register(permissions: Permission[]) {
    this.permissions.push(...permissions);
  }

  getAll() {
    return this.permissions;
  }
}