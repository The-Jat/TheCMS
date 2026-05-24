// modules/auth/oauth.service.ts

import crypto from 'crypto';

export class OAuthService {

    private authServer =
        'http://localhost:3000';

    private clientId =
        'app_8df531677f99ef42307dc0b44d79a481';

    private clientSecret =
        '9d969a055001830a205c5dd2cd509972d463765a1a48d4db2cb4179d05f4854c';

    private redirectUri =
        'http://localhost:4000/admin/callback';

    generatePkce() {

        const verifier =
            crypto.randomBytes(32)
                .toString('base64url');

        const challenge =
            crypto
                .createHash('sha256')
                .update(verifier)
                .digest('base64url');

        return {
            verifier,
            challenge,
        };
    }


    getAuthorizationUrl() {

        const state =
            crypto.randomUUID();

        const pkce =
            this.generatePkce();

        const url =
            new URL(
                `${this.authServer}/oauth/authorize`
            );

        url.searchParams.set(
            'client_id',
            this.clientId
        );

        url.searchParams.set(
            'redirect_uri',
            this.redirectUri
        );

        url.searchParams.set(
            'state',
            state
        );

        url.searchParams.set(
            'code_challenge',
            pkce.challenge
        );

        url.searchParams.set(
            'code_challenge_method',
            'S256'
        );

        return {
            url: url.toString(),
            state,
            verifier: pkce.verifier,
        };
    }
    async exchangeCode(
        code: string,
        verifier: string,
    ) {

        console.log(
            'Exchange code:',
            code,
        );

        const response = await fetch(
            `${this.authServer}/oauth/token`,
            {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    code,
                    client_id: this.clientId,
                    client_secret: this.clientSecret,
                    redirect_uri: this.redirectUri,
                    code_verifier: verifier,
                }),
            },
        );

        if (!response.ok) {

            const error =
                await response.text();

            throw new Error(
                `Token exchange failed: ${error}`,
            );
        }

        return response.json();
    }

    async getUser(token: string) {

        console.log(
            'Get user:',
            token
        );

        return {
            id: 1,
            name: 'TheJat',
            permissions: [
                'blog.read',
            ],
        };
    }

    async getCurrentUser(
        accessToken: string
    ) {
        const response = await fetch(
            `${this.authServer}/oauth/me`,
            {
                headers: {
                    Authorization: `Bearer ${accessToken}`,
                },
            }
        );

        if (!response.ok) {
            throw new Error('Unauthorized');
        }

        return response.json();
    }
}