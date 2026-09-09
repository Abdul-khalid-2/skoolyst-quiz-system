<?php
declare(strict_types=1);

namespace Skoolyst\Core;

class Session {
    public static function start(): void {
        if (session_status() === PHP_SESSION_ACTIVE) return;

        $name = $_ENV['SESSION_NAME'] ?? '';
        if ($name !== '') session_name($name);

        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'secure' => filter_var($_ENV['SESSION_SECURE'] ?? false, FILTER_VALIDATE_BOOLEAN),
            'httponly' => filter_var($_ENV['SESSION_HTTP_ONLY'] ?? true, FILTER_VALIDATE_BOOLEAN),
            'samesite' => 'Lax',
        ]);

        session_start();
    }
}
