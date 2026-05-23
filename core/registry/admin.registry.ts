export interface AdminNavigationItem {
  label: string;
  path: string;
}

export class AdminRegistry {
  private navigation: AdminNavigationItem[] = [];

  register(items: AdminNavigationItem[]) {
    this.navigation.push(...items);
  }

  getAll() {
    return this.navigation;
  }
}