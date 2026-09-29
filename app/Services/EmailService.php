<?php
declare(strict_types=1);

namespace Skoolyst\Services;

/**
 * Sends mail through the shared Skoolyst Email API (hosted on ads.skoolyst.com).
 * Every call is best-effort: a failure is logged and returns false, it never
 * throws, so a notification email can never break the admin action that
 * triggered it.
 */
class EmailService {
    public static function send(string $to, string $subject, string $body): bool {
        if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $baseUrl = config('email.base_url');
        $apiKey = config('email.api_key');
        if (!$baseUrl || !$apiKey) {
            error_log('Skoolyst Email API: EMAIL_API_BASE / EMAIL_API_KEY not configured, skipping send to ' . $to);
            return false;
        }

        try {
            $ch = curl_init(rtrim($baseUrl, '/') . '/email/send');
            curl_setopt_array($ch, [
                CURLOPT_POST => true,
                CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
                CURLOPT_POSTFIELDS => json_encode([
                    'api_key' => $apiKey,
                    'source_app' => config('email.source_app'),
                    'to' => $to,
                    'subject' => mb_substr($subject, 0, 255),
                    'body' => mb_substr($body, 0, 100000),
                ], JSON_UNESCAPED_UNICODE),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT => 5,
                CURLOPT_TIMEOUT => 10,
            ]);

            $response = curl_exec($ch);
            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $errno = curl_errno($ch);
            $error = curl_error($ch);
            curl_close($ch);

            if ($errno !== 0) {
                error_log("Skoolyst Email API: curl error sending to {$to}: {$error}");
                return false;
            }

            if ($status !== 201) {
                error_log("Skoolyst Email API: send to {$to} failed with HTTP {$status}: " . $response);
                return false;
            }

            return true;
        } catch (\Throwable $e) {
            error_log('Skoolyst Email API: unexpected error sending to ' . $to . ': ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Sends an activity notification to the configured admin inbox, falling back
     * to the currently logged-in admin's own email if none is configured.
     */
    public static function notifyAdmin(string $subject, string $body): bool {
        $to = self::adminEmail();
        if (!$to) {
            return false;
        }

        return self::send($to, $subject, $body);
    }

    private static function adminEmail(): ?string {
        $configured = trim((string) config('email.admin_email'));
        if ($configured !== '') {
            return $configured;
        }

        $user = auth_user();
        return $user['email'] ?? null;
    }
}
