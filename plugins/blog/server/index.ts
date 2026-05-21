import { PluginDefinition } from '@thejatcms/sdk';

const plugin: PluginDefinition = {
  name: 'blog',
  version: '1.0.0',

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
};

export default plugin;