import { AdminNavigationItem } from '@thejatcms/sdk';

export class AdminRegistry {
  private items: AdminNavigationItem[] = [];
  private pluginItems = new Map<string, any[]>();

  register(items: any[], pluginName = 'global') {
    this.items.push(...items);

    const existing = this.pluginItems.get(pluginName) || [];
    this.pluginItems.set(pluginName, [...existing, ...items]);
  }

  unregister(pluginName: string) {
    const items = this.pluginItems.get(pluginName);
    if (!items) return;

    this.items = this.items.filter(i => !items.includes(i));

    this.pluginItems.delete(pluginName);
  }

  replace(items: any[], pluginName: string) {
    this.unregister(pluginName);
    this.register(items, pluginName);
  }

  getAll() {
    return this.items;
  }
}