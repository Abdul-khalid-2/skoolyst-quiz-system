<?php
declare(strict_types=1);

namespace Skoolyst\Middleware;

use Skoolyst\Core\Response;

class AuthMiddleware {
    public function handle(): void {
        if (!is_authenticated()) {
            Response::redirect(route('login'));
        }
    }
}
