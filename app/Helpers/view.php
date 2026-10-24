<?php
function route(string $name, mixed $params = null): string {
    return url(\Skoolyst\Core\Router::urlFor($name, $params));
}

function asset(string $path): string {
    return url($path);
}

/**
 * Public origin (scheme + host) of the site. Prefers the host from APP_URL so a spoofed
 * Host header can never leak into canonical URLs, OG tags or JSON-LD. Falls back to the
 * request host only for local development (APP_URL pointing at localhost).
 */
function site_origin(): string {
    $appUrl = trim((string) ($_ENV['APP_URL'] ?? ''));
    $parts = $appUrl !== '' ? parse_url($appUrl) : false;
    $appHost = is_array($parts) ? strtolower((string) ($parts['host'] ?? '')) : '';
    $isLocal = $appHost === '' || $appHost === 'localhost' || $appHost === '127.0.0.1' || str_ends_with($appHost, '.test') || str_ends_with($appHost, '.local');

    if (!$isLocal) {
        return ($parts['scheme'] ?? 'https') . '://' . $appHost . (isset($parts['port']) ? ':' . $parts['port'] : '');
    }

    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || strtolower((string) ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '')) === 'https';
    $host = (string) ($_SERVER['HTTP_HOST'] ?? '');
    if (!preg_match('/^[A-Za-z0-9.\-]+(:\d+)?$/', $host)) {
        $host = $appHost !== '' ? $appHost : 'localhost';
    }
    return ($https ? 'https' : 'http') . '://' . $host;
}

/** Canonical URL of the current page: clean origin + path, no query string, no trailing slash. */
function canonical_url(): string {
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $path = $path === '/' ? '/' : rtrim($path, '/');
    return site_origin() . $path;
}

function base_url(): string {
    return site_origin();
}

/** Trim/clean text into a meta description (max ~158 chars, cut on a word boundary). */
function meta_description(string $text, int $max = 158): string {
    $text = trim(preg_replace('/\s+/u', ' ', strip_tags($text)) ?? '');
    if (mb_strlen($text) <= $max) return $text;
    $cut = mb_substr($text, 0, $max - 1);
    $space = mb_strrpos($cut, ' ');
    if ($space !== false && $space > $max * 0.6) $cut = mb_substr($cut, 0, $space);
    return rtrim($cut, " ,;:-.") . '…';
}

/** Absolute URL for a stored asset (OG image etc). */
function absolute_asset(string $path): string {
    if (preg_match('#^https?://#i', $path)) return $path;
    return site_origin() . '/' . ltrim($path, '/');
}

function request(): \Skoolyst\Core\CurrentRequest {
    return new \Skoolyst\Core\CurrentRequest();
}
