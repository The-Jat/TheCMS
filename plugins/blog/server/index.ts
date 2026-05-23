import { PluginDefinition } from '@thejatcms/sdk';

const plugin: PluginDefinition = {
  name: 'blog',
  version: '1.0.0',
  enabled: true,
  entry: './server/index.ts',

  routes: [
    {
      method: 'GET',
      path: '/blog',
    },
  ],

  permissions: ['blog.read'],

  adminNavigation: [
    {
      label: 'Blog',
      path: '/admin/blog',
    },
  ],

  onLoad(ctx) {
    ctx.services.logger.log('Blog loaded');

    ctx.register.routes(this.routes);
    ctx.register.permissions(this.permissions);
    ctx.register.adminNavigation(this.adminNavigation);
  },

  onEnable(ctx) {
    ctx.events.on('user.created', (user) => {
      ctx.services.logger.log('BLOG EVENT:', user);
    });
  },
};

export default plugin;