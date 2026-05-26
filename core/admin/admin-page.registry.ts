export interface AdminPage {
  path: string;
  component: string;
  plugin: string;
}

export class AdminPageRegistry {
  private pages: AdminPage[] = [];

  register(
    pages: Omit<AdminPage, 'plugin'>[],
    plugin: string,
  ) {
    this.pages.push(
      ...pages.map(p => ({
        ...p,
        plugin,
      })),
    );
  }

  getAll() {
    return this.pages;
  }

  unregister(plugin: string) {
    this.pages =
      this.pages.filter(
        p => p.plugin !== plugin,
      );
  }
}