<?php
function format_date(?string $date): string { return $date ? date('Y-m-d', strtotime($date)) : ''; }

function slugify(string $text): string {
    $slug = strtolower(trim($text));
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    return trim($slug, '-');
}
