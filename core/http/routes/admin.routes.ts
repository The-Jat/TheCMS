import { Router } from 'express';
import { AdminController } from '../controllers/admin.controller';

export class AdminRoutes {

    public router = Router();

    constructor(
        private controller: AdminController,
        private authMiddleware: any,
    ) {
        this.register();
    }

    private register() {

        const auth =
            this.authMiddleware.handle.bind(
                this.authMiddleware,
            );

        this.router.get(
            '/',
            auth,
            this.controller.dashboard.bind(
                this.controller,
            ),
        );

        this.router.get(
            '/plugins',
            auth,
            this.controller.plugins.bind(
                this.controller,
            ),
        );

        this.router.get(
            '/plugins/:name',
            auth,
            this.controller.pluginDetails.bind(
                this.controller,
            ),
        );
    }
}