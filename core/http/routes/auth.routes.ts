// core/http/routes/auth.routes.ts

import { Router } from 'express';
import { Container } from '../../container';

export class AuthRoutes {
  public router = Router();

  constructor(private container: Container) {
    this.register();
  }

  private register() {
    this.router.get('/login', (req, res) => {
      const oauth = this.container.get('oauth');

      const auth = oauth.getAuthorizationUrl();

      req.session.oauthState = auth.state;
      req.session.codeVerifier = auth.verifier;

      res.redirect(auth.url);
    });

    this.router.get('/callback', async (req, res) => {
      const oauth = this.container.get('oauth');

        const verifier = req.session?.codeVerifier;

        if (!verifier) {
            return res.status(400).send('Missing PKCE verifier');
        }

      const token = await oauth.exchangeCode(
        req.query.code as string,
        req.session.codeVerifier,
      );

      res.cookie('access_token', token.access_token, {
        httpOnly: true,
        sameSite: 'lax',
      });

      res.redirect('/admin');
    });
  }
}