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

  onLoad({ hooks }) {
    const blogHooks = hooks.namespace('blog');

    blogHooks.on('user.created', (user) => {
      console.log('BLOG GOT EVENT:', user);
    });
  },

  onEnable() {
    console.log('BLOG ENABLED');
  },
};

export default plugin;