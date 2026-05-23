import { AdminNavigationItem } from "../../packages/sdk/src/plugins";

export class AdminRegistry {
  private navigation: AdminNavigationItem[] = [];

  register(items: AdminNavigationItem[]) {
    this.navigation.push(...items);
  }

  getAll() {
    return this.navigation;
  }
}