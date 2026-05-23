import { Request, Response } from 'express';

export class RequestContext {
    constructor(
        public req: Request,
        public res: Response,
        public plugin?: any,
        public user?: any
    ) { }


    get body() {
        return this.req.body;
    }

    get params() {
        return this.req.params;
    }

    get query() {
        return this.req.query;
    }
}