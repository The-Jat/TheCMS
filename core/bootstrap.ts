import { HookSystem } from './hooks';

import { PluginLoader } from './plugin-loader';
import { AdminRegistry } from './registry/admin.registry';
import { PermissionRegistry } from './registry/permission.registry';
import { RouteRegistry } from './registry/route.registry';

async function bootstrap() {
  const hooks = new HookSystem();

  const routeRegistry = new RouteRegistry();

  const permissionRegistry =
    new PermissionRegistry();

  const adminRegistry =
    new AdminRegistry();
 
  hooks.on('plugin.beforeLoad', (manifest) => {
    console.log('🟡 BEFORE LOAD:', manifest.name);
  });

  hooks.on('plugin.loaded', (plugin) => {
    console.log('🟢 LOADED:', plugin.name);
  });

  hooks.on('plugin.afterLoad', (plugin) => {
    console.log('🔵 AFTER LOAD:', plugin.name);
  });

  const loader = new PluginLoader(
    routeRegistry,
    permissionRegistry,
    adminRegistry,
    hooks,
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