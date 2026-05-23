import { AdminNavigationItem } from '@thejatcms/sdk';

export class AdminRegistry {
  private navigation: AdminNavigationItem[] = [];

  register(items: AdminNavigationItem[]) {
    this.navigation.push(...items);
  }

  getAll() {
    return this.navigation;
  }
}