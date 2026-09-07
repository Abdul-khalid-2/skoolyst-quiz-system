<?php
declare(strict_types=1);

namespace Skoolyst\Core;

class Router {
    private array $routes = [];

    public function get(string $path, callable|array $handler, array $middleware = []): void {
        $this->add('GET', $path, $handler, $middleware);
    }

    public function post(string $path, callable|array $handler, array $middleware = []): void {
        $this->add('POST', $path, $handler, $middleware);
    }

    public function put(string $path, callable|array $handler, array $middleware = []): void {
        $this->add('PUT', $path, $handler, $middleware);
    }

    public function delete(string $path, callable|array $handler, array $middleware = []): void {
        $this->add('DELETE', $path, $handler, $middleware);
    }

    private function add(string $method, string $path, callable|array $handler, array $middleware): void {
        $this->routes[] = [
            'method' => $method,
            'pattern' => $this->toPattern($path),
            'handler' => $handler,
            'middleware' => $middleware,
        ];
    }

    private function toPattern(string $path): string {
        $path = '/' . trim($path, '/');
        $regex = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', '(?P<$1>[^/]+)', $path);
        return '#^' . $regex . '$#';
    }

    public function dispatch(string $method, string $uri): mixed {
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';

        $base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
        if ($base !== '' && str_starts_with($path, $base)) {
            $path = substr($path, strlen($base));
        }

        $path = rtrim($path, '/');
        if ($path === '') $path = '/';

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) continue;
            if (!preg_match($route['pattern'], $path, $matches)) continue;

            $params = array_filter($matches, fn($key) => is_string($key), ARRAY_FILTER_USE_KEY);

            foreach ($route['middleware'] as $middleware) {
                $instance = is_string($middleware) ? new $middleware() : $middleware;
                $instance->handle();
            }

            $handler = $route['handler'];
            if (is_array($handler)) {
                [$class, $action] = $handler;
                $controller = new $class();
                return $controller->$action(...array_values($params));
            }

            return $handler(...array_values($params));
        }

        http_response_code(404);
        View::render('errors/404');
        return null;
    }
}
