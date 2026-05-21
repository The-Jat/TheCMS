export interface PluginDefinition {
  name: string;
  version: string;

  routes?: unknown[];
  permissions?: string[];
  hooks?: unknown[];
  adminNavigation?: unknown[];
}