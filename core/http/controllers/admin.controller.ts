import { Request, Response } from 'express';
import { PluginAdminService } from '../../admin/plugin-admin.service';

export class AdminController {

  constructor(
    private admin: PluginAdminService,
  ) {}

  dashboard(req: Request, res: Response) {

    return res.send(
      `Welcome ${(req as any).user.name}`,
    );
  }

  plugins(req: Request, res: Response) {

    return res.json(
      this.admin.getPlugins(),
    );
  }

  pluginDetails(req: Request, res: Response) {

    const data =
      this.admin.getPluginDetails(
        req.params.name,
      );

    if (!data) {
      return res.status(404).json({
        error: 'Not found',
      });
    }

    return res.json(data);
  }
}