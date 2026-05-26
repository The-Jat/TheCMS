import { Request, Response } from 'express';

export interface RouteDefinition {
  method:
  | 'GET'
  | 'POST'
  | 'PUT'
  | 'PATCH'
  | 'DELETE';

  path: string;
  handler: string;
  permission?: string;
  middlewares?: string[];
}

export interface RequestContext {
  req: Request;
  res: Response;

  user?: any;
  plugin?: any;

  params: Record<string, string>;
  query: Record<string, any>;
  body: any;

  json(data: any): {
    type: 'json';
    data: any;
  };

  status(code: number): {
    type: 'status';
    code: number;
  };
}

export type PluginHandler =
  (ctx: RequestContext) => any | Promise<any>;

export type EventHandler =
  (payload?: any) => void | Promise<void>;

export interface AdminNavigationItem {
  label: string;
  path: string;
}

export type Permission = string;

export interface PluginHookDefinition {
  event: string;
  handler: EventHandler;
}

export interface AdminRoute {
  path: string;
  component: string;
  exact?: boolean;
}

export interface PublicRoute {
  path: string;
  component: string;
}

export interface PluginDefinition {
  name: string;
  version: string;

  enabled: boolean;
  entry: string;

  server?: {
    routes?: RouteDefinition[];
    permissions?: Permission[];
    handlers?: Record<string, PluginHandler>;
  };

  admin?: {
    entry: string;

    routes: AdminRoute[];

    navigation: AdminNavigationItem[];
  };

  public?: {
    entry: string;

    routes: PublicRoute[];
  };

  dependencies?: string[];

  hooks?: PluginHookDefinition[];

  onLoad?: (
    ctx: PluginContext
  ) => void | Promise<void>;

  onEnable?: (
    ctx: PluginContext
  ) => void | Promise<void>;

  onDisable?: (
    ctx: PluginContext
  ) => void | Promise<void>;
}

export interface PluginContext {
  services: {
    logger: any;
    [key: string]: any;
  };

  events: {
    on: (
      event: string,
      cb: EventHandler
    ) => void;

    emit: (
      event: string,
      data?: any
    ) => Promise<void>;
  }
}