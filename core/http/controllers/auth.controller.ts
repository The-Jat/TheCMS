import { Request, Response } from 'express';
import { OAuthService } from '../../../modules/auth/oauth.service';

export class AuthController {

  constructor(
    private oauth: OAuthService,
  ) {}

  login(req: Request, res: Response) {

    const auth =
      this.oauth.getAuthorizationUrl();

    req.session.oauthState =
      auth.state;

    req.session.codeVerifier =
      auth.verifier;

    return res.redirect(auth.url);
  }

  async callback(req: Request, res: Response) {

    const verifier =
      req.session?.codeVerifier;

    if (!verifier) {
      return res.status(400).send(
        'Missing PKCE verifier'
      );
    }

    const token =
      await this.oauth.exchangeCode(
        req.query.code as string,
        verifier,
      );

    res.cookie('access_token', token.access_token, {
      httpOnly: true,
      sameSite: 'lax',
    });

    res.cookie('refresh_token', token.refresh_token, {
      httpOnly: true,
      sameSite: 'lax',
    });

    return res.redirect('/admin');
  }
}