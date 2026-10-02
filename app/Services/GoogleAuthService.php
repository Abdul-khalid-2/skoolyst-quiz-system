<?php
declare(strict_types=1);

namespace Skoolyst\Services;

/**
 * "Login with Google" — standard OAuth2 Authorization Code flow against
 * Google's own identity platform (no Skoolyst infrastructure involved).
 * Plain PHP app, so this talks to Google directly via curl rather than Socialite.
 */
class GoogleAuthService {
    private const STATE_SESSION_KEY = 'google_oauth_state';
    private const AUTH_ENDPOINT = 'https://accounts.google.com/o/oauth2/v2/auth';
    private const TOKEN_ENDPOINT = 'https://oauth2.googleapis.com/token';
    private const USERINFO_ENDPOINT = 'https://www.googleapis.com/oauth2/v3/userinfo';

    public function isConfigured(): bool {
        $config = config('google_auth');
        return $config['client_id'] !== '' && $config['client_secret'] !== '' && $config['redirect_uri'] !== '';
    }

    /**
     * Builds the Google consent-screen URL and stores a fresh CSRF state in the session.
     */
    public function authorizeUrl(): string {
        $state = bin2hex(random_bytes(16));
        $_SESSION[self::STATE_SESSION_KEY] = $state;

        $query = http_build_query([
            'client_id' => config('google_auth.client_id'),
            'redirect_uri' => config('google_auth.redirect_uri'),
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'state' => $state,
            'prompt' => 'select_account',
        ]);

        return self::AUTH_ENDPOINT . '?' . $query;
    }

    /**
     * Verifies the callback's state, exchanges the code for tokens, and fetches the
     * user's profile. Returns ['id', 'name', 'email', 'email_verified'].
     *
     * @throws \RuntimeException on a state mismatch or any Google-side failure.
     */
    public function handleCallback(string $code, string $state): array {
        $expectedState = $_SESSION[self::STATE_SESSION_KEY] ?? '';
        unset($_SESSION[self::STATE_SESSION_KEY]);

        if ($expectedState === '' || !hash_equals($expectedState, $state)) {
            throw new \RuntimeException('OAuth state mismatch — possible CSRF, aborting.');
        }

        $accessToken = $this->exchangeCodeForToken($code);
        $profile = $this->fetchProfile($accessToken);

        if (empty($profile['sub']) || empty($profile['email'])) {
            throw new \RuntimeException('Could not read your Google profile. Please try again.');
        }

        return [
            'id' => (string) $profile['sub'],
            'name' => $profile['name'] ?? strstr($profile['email'], '@', true) ?: $profile['email'],
            'email' => strtolower(trim((string) $profile['email'])),
            'email_verified' => (bool) ($profile['email_verified'] ?? false),
        ];
    }

    private function exchangeCodeForToken(string $code): string {
        $ch = curl_init(self::TOKEN_ENDPOINT);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'code' => $code,
                'client_id' => config('google_auth.client_id'),
                'client_secret' => config('google_auth.client_secret'),
                'redirect_uri' => config('google_auth.redirect_uri'),
                'grant_type' => 'authorization_code',
            ]),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 15,
        ]);

        $raw = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $errno = curl_errno($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($errno !== 0) {
            throw new \RuntimeException('Could not reach Google: ' . $error);
        }

        $response = json_decode((string) $raw, true);

        if ($status !== 200 || empty($response['access_token'])) {
            error_log('Google OAuth token exchange failed (HTTP ' . $status . '): ' . $raw);
            throw new \RuntimeException('Google login failed. Please try again.');
        }

        return $response['access_token'];
    }

    private function fetchProfile(string $accessToken): array {
        $ch = curl_init(self::USERINFO_ENDPOINT);
        curl_setopt_array($ch, [
            CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $accessToken],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 15,
        ]);

        $raw = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $errno = curl_errno($ch);
        curl_close($ch);

        if ($errno !== 0 || $status !== 200) {
            error_log('Google OAuth userinfo fetch failed (HTTP ' . $status . '): ' . $raw);
            throw new \RuntimeException('Could not read your Google profile. Please try again.');
        }

        return json_decode((string) $raw, true) ?: [];
    }
}
