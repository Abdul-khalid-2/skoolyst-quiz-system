<?php
declare(strict_types=1);

namespace Skoolyst\Core;

class Router {
    private array $routes = [];
    private static array $namedRoutes = [];
    private static ?string $currentRouteName = null;

    public function get(string $path, callable|array $handler, array $middleware = []): self {
        return $this->add('GET', $path, $handler, $middleware);
    }

    public function post(string $path, callable|array $handler, array $middleware = []): self {
        return $this->add('POST', $path, $handler, $middleware);
    }

    public function put(string $path, callable|array $handler, array $middleware = []): self {
        return $this->add('PUT', $path, $handler, $middleware);
    }

    public function delete(string $path, callable|array $handler, array $middleware = []): self {
        return $this->add('DELETE', $path, $handler, $middleware);
    }

    public function name(string $name): self {
        $lastKey = array_key_last($this->routes);
        if ($lastKey !== null) {
            $this->routes[$lastKey]['name'] = $name;
            self::$namedRoutes[$name] = $this->routes[$lastKey]['path'];
        }
        return $this;
    }

    private function add(string $method, string $path, callable|array $handler, array $middleware): self {
        $this->routes[] = [
            'method' => $method,
            'path' => '/' . trim($path, '/'),
            'pattern' => $this->toPattern($path),
            'handler' => $handler,
            'middleware' => $middleware,
            'name' => null,
        ];
        return $this;
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
            self::$currentRouteName = $route['name'];

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

    public static function currentRouteName(): ?string {
        return self::$currentRouteName;
    }

    public static function urlFor(string $name, mixed $params = null): string {
        if (!isset(self::$namedRoutes[$name])) {
            throw new \RuntimeException("Route not found: {$name}");
        }

        $path = self::$namedRoutes[$name];

        if ($params !== null) {
            $params = is_array($params) ? array_values($params) : [$params];
            $i = 0;
            $path = preg_replace_callback(
                '/\{[a-zA-Z_][a-zA-Z0-9_]*\}/',
                fn() => (string) ($params[$i++] ?? ''),
                $path
            );
        }

        return $path;
    }
}
