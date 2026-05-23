export interface RouteDefinition {
  method: string;
  path: string;
}

export class RouteRegistry {
  private routes: RouteDefinition[] = [];

  register(routes: RouteDefinition[]) {
    this.routes.push(...routes);
  }

  getAll() {
    return this.routes;
  }
}