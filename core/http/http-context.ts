import { IncomingMessage, ServerResponse } from 'http';

export class RequestContext {
  constructor(
    public req: IncomingMessage,
    public res: ServerResponse
  ) {}

  json(data: any, status = 200) {
    this.res.statusCode = status;
    this.res.setHeader('Content-Type', 'application/json');
    this.res.end(JSON.stringify(data));
  }

  text(data: string, status = 200) {
    this.res.statusCode = status;
    this.res.setHeader('Content-Type', 'text/plain');
    this.res.end(data);
  }
}