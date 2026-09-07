<?php
function route(string $name, mixed $params = null): string {
    return url(\Skoolyst\Core\Router::urlFor($name, $params));
}

function asset(string $path): string {
    return url($path);
}

function request(): \Skoolyst\Core\CurrentRequest {
    return new \Skoolyst\Core\CurrentRequest();
}
