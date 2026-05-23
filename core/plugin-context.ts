import { HookSystem } from './hooks';
import { Container } from './container';
import { RouteRegistry } from './registry/route.registry';
import { PermissionRegistry } from './registry/permission.registry';
import { AdminRegistry } from './registry/admin.registry';

export class PluginContext {
  public readonly plugin: {
    name: string;
    version: string;
  };

  public readonly events: ReturnType<HookSystem['forPlugin']>;

  public readonly services: {
    logger: any;
    config: any;
  };

  public readonly register: {
    routes: (r: any) => void;
    permissions: (p: any) => void;
    adminNavigation: (a: any) => void;
  };

  public state: Record<string, any> = {};

  constructor(
    plugin: { name: string; version: string },
    private readonly hooks: HookSystem,
    private readonly container: Container,
    private readonly registries: {
      route: RouteRegistry;
      permission: PermissionRegistry;
      admin: AdminRegistry;
    }
  ) {
    this.plugin = plugin;

    // plugin-scoped events
    this.events = this.hooks.forPlugin(plugin.name);

    // shared services
    this.services = {
      logger: this.container.get('logger'),
      config: this.container.get('config'),
    };

    // controlled registry access (IMPORTANT FIX)
    this.register = {
      routes: (r) => this.registries.route.register(r),
      permissions: (p) => this.registries.permission.register(p),
      adminNavigation: (a) => this.registries.admin.register(a),
    };
  }
}