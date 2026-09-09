<?php
function route(string $name, mixed $params = null): string {
    return url(\Skoolyst\Core\Router::urlFor($name, $params));
}

function asset(string $path): string {
    return url($path);
}

function canonical_url(): string {
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? parse_url($_ENV['APP_URL'] ?? '', PHP_URL_HOST) ?? '';
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    return $scheme . '://' . $host . $path;
}

function request(): \Skoolyst\Core\CurrentRequest {
    return new \Skoolyst\Core\CurrentRequest();
}
