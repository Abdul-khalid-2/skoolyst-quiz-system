<?php
declare(strict_types=1);

namespace Skoolyst\Middleware;

use Skoolyst\Core\Response;

class AdminMiddleware {
    public function handle(): void {
        if (!is_authenticated()) {
            $isPage = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET';
            Response::redirect($isPage ? login_url($_SERVER['REQUEST_URI'] ?? null) : route('login'));
        }

        if (!is_admin()) {
            Response::redirect(route('home'));
        }
    }
}
