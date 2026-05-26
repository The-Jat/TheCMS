export interface AdminPageDefinition {
  plugin: string;

  path: string;

  component: string;
}

export class AdminPageRegistry {
  private pages: AdminPageDefinition[] = [];

  register(pages: AdminPageDefinition[]) {
    this.pages.push(...pages);
  }

  getAll() {
    return this.pages;
  }
}