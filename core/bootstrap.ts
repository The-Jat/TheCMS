import { Container } from './container';
import { HookSystem } from './hooks';

import { PluginLoader } from './plugin-loader';
import { AdminRegistry } from './registry/admin.registry';
import { PermissionRegistry } from './registry/permission.registry';
import { RouteRegistry } from './registry/route.registry';
import { HttpServer } from './http/server';
import { PluginAdminService } from './admin/plugin-admin.service';

async function bootstrap() {
  const container = new Container();
  container.register('logger', console);

  container.register('config', {
    appName: 'TheCMS',
  });

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
    container,
  );

  await loader.discover();

  console.log('ROUTES');
  console.log(routeRegistry.getAll());

  console.log('PERMISSIONS');
  console.log(permissionRegistry.getAll());

  console.log('ADMIN NAVIGATION');
  console.log(adminRegistry.getAll());

  // Emitting scoped event 1:
  // await hooks.forPlugin('blog').emit('user.created', {
  //   id: 1,
  //   name: 'TheJat',
  // });

  // Emitting scoped event 2:
  await hooks.emit('blog:user.created', {
    id: 1,
    name: 'TheJat',
  });

  // test hot reload
  // setTimeout(async () => {
  //   await loader.reloadPlugin('blog');
  // }, 3000);

  // HTTP server
  const admin = new PluginAdminService(loader);
  const server = new HttpServer(routeRegistry, loader, admin);

  const app = server.init();
  server.listen(3000);
}

bootstrap();