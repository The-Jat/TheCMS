import { Request, Response, NextFunction } from 'express';

export type Middleware = (
  req: Request,
  res: Response,
  next: NextFunction
) => void | Promise<void>;

export class MiddlewarePipeline {
  private middlewares: Middleware[] = [];

  use(mw: Middleware) {
    this.middlewares.push(mw);
  }

  async run(req: Request, res: Response) {
    let index = 0;

    const next = async () => {
      const mw = this.middlewares[index++];
      if (mw) await mw(req, res, next);
    };

    await next();
  }
}