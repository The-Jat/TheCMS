export interface ModuleContext {
  services: {
    logger: any;
    config: any;
    [key: string]: any;
  };
}

export interface ModuleDefinition {
  name: string;
  version: string;

  register?(ctx: ModuleContext): void | Promise<void>;

  boot?(ctx: ModuleContext): void | Promise<void>;

  shutdown?(ctx: ModuleContext): void | Promise<void>;
}