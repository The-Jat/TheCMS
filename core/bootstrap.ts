import { PluginLoader } from './plugin-loader';
import { AdminRegistry } from './registry/admin.registry';
import { PermissionRegistry } from './registry/permission.registry';
import { RouteRegistry } from './registry/route.registry';

async function bootstrap() {
  const routeRegistry = new RouteRegistry();

  const permissionRegistry =
    new PermissionRegistry();

  const adminRegistry =
    new AdminRegistry();

  const loader = new PluginLoader(
    routeRegistry,
    permissionRegistry,
    adminRegistry,
  );

  await loader.discover();

  console.log('ROUTES');
  console.log(routeRegistry.getAll());

  console.log('PERMISSIONS');
  console.log(permissionRegistry.getAll());

  console.log('ADMIN NAVIGATION');
  console.log(adminRegistry.getAll());
}

bootstrap();