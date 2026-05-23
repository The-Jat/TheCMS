import { Permission } from '@thejatcms/sdk';

export class PermissionRegistry {
  private permissions: Permission[] = [];

  private pluginPermissions = new Map<string, string[]>();

  register(perms: string[], pluginName = 'global') {
    this.permissions.push(...perms);

    const existing = this.pluginPermissions.get(pluginName) || [];
    this.pluginPermissions.set(pluginName, [...existing, ...perms]);
  }

  unregister(pluginName: string) {
    const perms = this.pluginPermissions.get(pluginName);
    if (!perms) return;

    this.permissions = this.permissions.filter(
      p => !perms.includes(p)
    );

    this.pluginPermissions.delete(pluginName);
  }

  replace(perms: string[], pluginName: string) {
    this.unregister(pluginName);
    this.register(perms, pluginName);
  }

  getAll() {
    return this.permissions;
  }
}