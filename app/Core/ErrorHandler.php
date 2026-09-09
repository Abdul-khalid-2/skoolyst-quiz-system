<?php
declare(strict_types=1);

namespace Skoolyst\Core;

/**
 * Central production error handling: keeps stack traces/paths out of responses
 * unless APP_DEBUG is on, and always logs the real error to storage/logs.
 */
class ErrorHandler {
    public static function register(): void {
        $debug = config('app.debug', false);

        ini_set('display_errors', $debug ? '1' : '0');
        ini_set('log_errors', '1');
        error_reporting(E_ALL);

        set_error_handler(function (int $severity, string $message, string $file, int $line): bool {
            if (!(error_reporting() & $severity)) return false;
            throw new \ErrorException($message, 0, $severity, $file, $line);
        });

        set_exception_handler(function (\Throwable $e): void {
            self::log($e);
            self::render($e);
        });

        register_shutdown_function(function (): void {
            $error = error_get_last();
            if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR], true)) {
                $e = new \ErrorException($error['message'], 0, $error['type'], $error['file'], $error['line']);
                self::log($e);
                self::render($e);
            }
        });
    }

    private static function log(\Throwable $e): void {
        $dir = dirname(__DIR__, 2) . '/storage/logs';
        if (!is_dir($dir)) mkdir($dir, 0777, true);

        $line = sprintf(
            '[%s] %s: %s in %s:%d%s%s',
            date('Y-m-d H:i:s'),
            get_class($e),
            $e->getMessage(),
            $e->getFile(),
            $e->getLine(),
            PHP_EOL,
            $e->getTraceAsString()
        );

        error_log($line . PHP_EOL, 3, $dir . '/app-' . date('Y-m-d') . '.log');
    }

    private static function render(\Throwable $e): void {
        if (ob_get_level() > 0) ob_end_clean();

        http_response_code(500);

        if (config('app.debug', false)) {
            echo '<pre style="white-space:pre-wrap;padding:1.5rem;font:13px/1.5 monospace;">';
            echo htmlspecialchars(get_class($e) . ': ' . $e->getMessage() . "\n\n" . $e->getTraceAsString(), ENT_QUOTES, 'UTF-8');
            echo '</pre>';
            return;
        }

        try {
            View::render('errors/500');
        } catch (\Throwable) {
            echo 'Something went wrong. Please try again later.';
        }
    }
}
