import { Request, Response } from 'express';

export class RequestContext {
  constructor(
    public req: Request,
    public res: Response,
    public plugin?: any,
    public user?: any
  ) {}

}