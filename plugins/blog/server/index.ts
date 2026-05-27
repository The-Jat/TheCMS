// plugins/blog/server/index.ts

import { PluginDefinition, PluginContext } from '@thejatcms/sdk';

const plugin: PluginDefinition = {
  name: 'blog',
  version: '1.0.0',
  enabled: true,
  entry: './server/index.ts',

  admin: {
    // entry: "/plugins/blog/admin.js",
    entry: "/plugins/blog/admin/dist/admin.js",

    navigation: [
      {
        label: "Blog",
        icon: "FileText",
        path: "/blog"
      }
    ],

    routes: [
      {
        path: "/blog",
        component: "BlogList"
      },
      {
        path: "/blog/create",
        component: "BlogCreate"
      }
    ]
  },

  routes: [
    {
      method: 'GET',
      path: '/blog/:id',
      handler: 'getPosts',
      permission: 'blog.read',
    },
  ],
  handlers: {
    getPosts: async (ctx) => {
      const id = ctx.params.id;
      console.log(id);
      return [
        { id: 1, title: 'Secure Blog Post' },
        { id: 2, title: 'Permission Protected Data' },
      ];
    },
  },

  permissions: ['blog.read'],

  adminNavigation: [
    {
      label: 'Blog',
      path: '/admin/blog',
    },
  ],

  onLoad(ctx: PluginContext) {
    ctx.services.logger.log('Blog loaded');
  },

  onEnable(ctx: PluginContext) {
    ctx.events.on('user.created', (user) => {
      ctx.services.logger.log('BLOG EVENT:', user);
    });
  },
};

export default plugin;