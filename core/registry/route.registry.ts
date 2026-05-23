// import { RouteDefinition } from "../../packages/sdk/src/plugins";
import { RouteDefinition } from '@thejatcms/sdk';
export class RouteRegistry {
  private routes: RouteDefinition[] = [];

  register(routes: RouteDefinition[]) {
    this.routes.push(...routes);
  }

  getAll() {
    return this.routes;
  }
}