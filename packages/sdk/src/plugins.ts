export interface RouteDefinition {
  method:
    | 'GET'
    | 'POST'
    | 'PUT'
    | 'PATCH'
    | 'DELETE';

  path: string;
}

export interface AdminNavigationItem {
  label: string;
  path: string;
}

export type Permission = string;
export interface PluginDefinition {
  name: string;
  version: string;
  enabled: boolean;
  entry: string;

  routes?: RouteDefinition[];
  permissions?: Permission[];
  hooks?: unknown[];
  adminNavigation?: AdminNavigationItem[];
  dependencies?: string[];
}