<?php
function config(string $key, mixed $default = null): mixed {
    static $cache = [];

    [$file, $item] = array_pad(explode('.', $key, 2), 2, null);
    if (!array_key_exists($file, $cache)) {
        $path = dirname(__DIR__, 2) . '/config/' . $file . '.php';
        $cache[$file] = is_file($path) ? require $path : [];
    }

    if ($item === null) return $cache[$file];
    return $cache[$file][$item] ?? $default;
}

function format_date(?string $date): string { return $date ? date('Y-m-d', strtotime($date)) : ''; }

function slugify(string $text): string {
    $slug = strtolower(trim($text));
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    return trim($slug, '-');
}
