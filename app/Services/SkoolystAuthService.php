<?php
declare(strict_types=1);

namespace Skoolyst\Services;

/**
 * "Login with Skoolyst" — OAuth2 Authorization Code flow against skoolyst.com,
 * the central identity provider for the Skoolyst family of apps.
 */
class SkoolystAuthService {
    private const STATE_SESSION_KEY = 'skoolyst_oauth_state';

    public function isConfigured(): bool {
        $config = config('skoolyst_auth');
        return $config['base_url'] !== '' && $config['client_id'] !== '' && $config['client_secret'] !== '' && $config['redirect_uri'] !== '';
    }

    /**
     * Builds the /oauth/authorize URL and stores a fresh CSRF state in the session.
     */
    public function authorizeUrl(): string {
        $state = bin2hex(random_bytes(16));
        $_SESSION[self::STATE_SESSION_KEY] = $state;

        $query = http_build_query([
            'client_id' => config('skoolyst_auth.client_id'),
            'redirect_uri' => config('skoolyst_auth.redirect_uri'),
            'state' => $state,
        ]);

        return config('skoolyst_auth.base_url') . '/oauth/authorize?' . $query;
    }

    /**
     * Verifies the callback's state, exchanges the code for the user's identity, and
     * returns the API's 'data' payload: ['user' => [...], 'access_token' => ..., 'token_type' => ...].
     *
     * @throws \RuntimeException on a state mismatch or any API-side failure.
     */
    public function handleCallback(string $code, string $state): array {
        $expectedState = $_SESSION[self::STATE_SESSION_KEY] ?? '';
        unset($_SESSION[self::STATE_SESSION_KEY]);

        if ($expectedState === '' || !hash_equals($expectedState, $state)) {
            throw new \RuntimeException('OAuth state mismatch — possible CSRF, aborting.');
        }

        $ch = curl_init(config('skoolyst_auth.base_url') . '/api/oauth/token');
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => json_encode([
                'client_id' => config('skoolyst_auth.client_id'),
                'client_secret' => config('skoolyst_auth.client_secret'),
                'code' => $code,
                'redirect_uri' => config('skoolyst_auth.redirect_uri'),
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
            throw new \RuntimeException('Could not reach Skoolyst login service: ' . $error);
        }

        $response = json_decode((string) $raw, true);

        if ($status !== 201 || empty($response['success'])) {
            $message = $response['error']['message'] ?? 'Login with Skoolyst failed.';
            error_log('Skoolyst OAuth token exchange failed (HTTP ' . $status . '): ' . $raw);
            throw new \RuntimeException($message);
        }

        return $response['data'];
    }
}
