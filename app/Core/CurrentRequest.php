<?php
declare(strict_types=1);

namespace Skoolyst\Core;

class CurrentRequest {
    public function routeIs(string $pattern): bool {
        $name = Router::currentRouteName();
        if ($name === null) return false;
        if ($pattern === $name) return true;

        if (str_ends_with($pattern, '.*')) {
            $prefix = substr($pattern, 0, -1);
            return str_starts_with($name, $prefix);
        }

        return fnmatch($pattern, $name);
    }
}
