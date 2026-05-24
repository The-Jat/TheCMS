import { ModuleDefinition } from '@thejatcms/sdk';

const module: ModuleDefinition = {

  name: 'auth',

  version: '1.0.0',

  register(ctx) {
    ctx.services.logger.log(
      'Auth module registered'
    );
  },

  boot(ctx) {
    ctx.services.logger.log(
      'Auth module booted'
    );
  },
};

export default module;