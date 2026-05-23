import { RouteRegistry } from '../registry/route.registry';

export class RouteResolver {

  constructor(
    private routeRegistry: RouteRegistry,
  ) {}

  resolve(req: any) {

    for (const route of this.routeRegistry.getAll()) {

      if (
        route.method.toUpperCase() !==
        req.method.toUpperCase()
      ) {
        continue;
      }

      const matched =
        route.matcher(req.path);

      if (!matched) {
        continue;
      }

      return {
        route,
        params: matched.params,
      };
    }

    return null;
  }
}