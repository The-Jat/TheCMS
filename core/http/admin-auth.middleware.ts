import { OAuthService } from
    '../../modules/auth/oauth.service';

export class AdminAuthMiddleware {

    constructor(
        private oauth: OAuthService,
    ) { }

    async handle(req: any, res: any, next: any) {

        const token =
            req.cookies?.access_token;

        if (!token) {

            return res.redirect('/admin/login');
            // return res.redirect(
            //     this.oauth.getAuthorizationUrl()
            // );
        }

        try {

            const user = await this.oauth.getCurrentUser(token);

            req.user = user;

            next();

        } catch {

            return res.redirect('/admin/login');
            // return res.redirect(
            //     this.oauth.getAuthorizationUrl()
            // );
        }
    }
}