// core/http/routes/auth.routes.ts

import { Router } from 'express';
import { AuthController } from '../controllers/auth.controller';

export class AuthRoutes {

  public router = Router();

  constructor(
    private controller: AuthController,
  ) {
    this.register();
  }

  private register() {

    this.router.get(
      '/login',
      this.controller.login.bind(this.controller),
    );

    this.router.get(
      '/callback',
      this.controller.callback.bind(this.controller),
    );
  }
}