import { Request, Response } from 'express';

export type MiddlewareFn = (
  req: Request,
  res: Response,
  next: () => void
) => void | Promise<void>;

export class MiddlewarePipeline {
  private middlewares: MiddlewareFn[] = [];

  use(fn: MiddlewareFn) {
    this.middlewares.push(fn);
  }

  async execute(req: Request, res: Response) {
    for (const mw of this.middlewares) {
      await new Promise<void>((resolve) => {
        mw(req, res, resolve);
      });
    }
  }
}