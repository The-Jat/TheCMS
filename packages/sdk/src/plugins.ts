export interface RouteDefinition {
  method:
    | 'GET'
    | 'POST'
    | 'PUT'
    | 'PATCH'
    | 'DELETE';

  path: string;
  handler: string;
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

export interface PluginContext {
  hooks: {
    on: (event: string, cb: Function) => void;
    emit: (event: string, data?: any) => Promise<void>;
  };

  register: {
    routes: (r: RouteDefinition[]) => void;
    permissions: (p: Permission[]) => void;
    adminNavigation: (a: AdminNavigationItem[]) => void;
  };
}