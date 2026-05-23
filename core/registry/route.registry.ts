import { RouteDefinition } from "../../packages/sdk/src/plugins";

export class RouteRegistry {
  private routes: RouteDefinition[] = [];

  register(routes: RouteDefinition[]) {
    this.routes.push(...routes);
  }

  getAll() {
    return this.routes;
  }
}