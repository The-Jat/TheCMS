import { Request, Response } from 'express';

export class RequestContext {
    constructor(
        public req: Request,
        public res: Response,
        public plugin?: any,
        public user?: any,
    ) { }

    // request data

    get body() {
        return this.req.body;
    }

    get params() {
        return this.req.params;
    }

    get query() {
        return this.req.query;
    }

    get headers() {
        return this.req.headers;
    }

    get method() {
        return this.req.method;
    }

    get path() {
        return this.req.path;
    }

    get ip() {
        return this.req.ip;
    }

    // response helpers

    json(data: any) {
        return this.res.json(data);
    }

    status(code: number) {
        this.res.status(code);
        return this;
    }

    send(data: any) {
        return this.res.send(data);
    }

    redirect(url: string) {
        return this.res.redirect(url);
    }

    notFound(message = 'Not Found') {
        return this.res.status(404).json({
            error: message,
        });
    }

    forbidden(message = 'Forbidden') {
        return this.res.status(403).json({
            error: message,
        });
    }

    ok(data: any) {
        return this.res.status(200).json(data);
    }
}