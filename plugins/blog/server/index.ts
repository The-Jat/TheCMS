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

  onLoad({ events, services }) {
    services.logger.log('Blog plugin started');

    events.on('user.created', (user) => {
      services.logger.log('BLOG GOT EVENT:', user);
    });
  },

  onEnable() {
    console.log('BLOG ENABLED');
  },
};

export default plugin;