import { Container } from './container';
import { HookSystem } from './hooks';

import { PluginLoader } from './plugin-loader';
import { AdminRegistry } from './registry/admin.registry';
import { PermissionRegistry } from './registry/permission.registry';
import { RouteRegistry } from './registry/route.registry';
import { HttpServer } from './http/server';
import { PluginAdminService } from './admin/plugin-admin.service';
import { RequestPipelineEngine } from './http/request-pipeline.engine';
import { PermissionService } from './auth/permission.service';
import { MiddlewarePipeline } from './http/middleware';

async function bootstrap() {
  const container = new Container();
  container.register('logger', console);

  container.register('config', {
    appName: 'TheCMS',
  });

  const hooks = new HookSystem();

  // Registeries
  const routeRegistry = new RouteRegistry();
  const permissionRegistry = new PermissionRegistry();
  const adminRegistry = new AdminRegistry();

  hooks.on('plugin.beforeLoad', (manifest) => {
    console.log('🟡 BEFORE LOAD:', manifest.name);
  });

  hooks.on('plugin.loaded', (plugin) => {
    console.log('🟢 LOADED:', plugin.name);
  });

  hooks.on('plugin.afterLoad', (plugin) => {
    console.log('🔵 AFTER LOAD:', plugin.name);
  });

  hooks.on('request.before', ({ req }) => {
    console.log('🟡 REQUEST BEFORE:', req.method, req.path);
  });

  hooks.on('request.after', ({ req }) => {
    console.log('🟢 REQUEST AFTER:', req.method, req.path);
  });

  hooks.on('handler.before', ({ route }) => {
    console.log('🔵 HANDLER BEFORE:', route.path);
  });

  hooks.on('handler.after', ({ route }) => {
    console.log('🟣 HANDLER AFTER:', route.path);
  });

  const loader = new PluginLoader(
    routeRegistry,
    permissionRegistry,
    adminRegistry,
    hooks,
    container,
  );

  const auth = new PermissionService();
  const pipeline = new MiddlewarePipeline();

  // register middleware 
  pipeline.use(async (req: any, res, next) => {
    console.log(`Incoming: ${req.method} ${req.path}`);

    req.user = {
      id: 1,
      name: 'TheJat',
      permissions: ['blog.read'],
    };

    next();
  });

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

  // HTTP server
  const admin = new PluginAdminService(loader);

  const reqPipeline = new RequestPipelineEngine(
    routeRegistry,
    loader,
    auth,
    hooks,
    pipeline,
  );
  const server = new HttpServer(routeRegistry, loader, admin, reqPipeline);

  const app = server.init();
  server.listen(3000);
}

bootstrap();