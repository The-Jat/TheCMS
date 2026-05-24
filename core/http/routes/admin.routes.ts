import { Router } from 'express';
import { PluginAdminService } from '../../admin/plugin-admin.service';

export class AdminRoutes {
    public router = Router();

    constructor(
        private admin: PluginAdminService,
        private authMiddleware: any,
    ) {
        this.register();
    }

    private register() {

        const auth =
            this.authMiddleware.handle.bind(this.authMiddleware);

        this.router.get(
            '/',
            auth,
            (req: any, res) => {
                res.send(`Welcome ${req.user.name}`);
            },
        );

        this.router.get(
            '/plugins',
            auth,
            (req, res) => {
                res.json(this.admin.getPlugins());
            },
        );
    }
}