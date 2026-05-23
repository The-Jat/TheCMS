export class RequestContext {
  constructor(
    public req: Request,
    public res: Response,
    public plugin?: any,
    public user?: any
  ) {}

  json(data: any) {
    return {
      type: 'json',
      data,
    };
  }

  status(code: number) {
    return {
      type: 'status',
      code,
    };
  }
}