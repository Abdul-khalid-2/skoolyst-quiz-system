<?php
declare(strict_types=1);

namespace Skoolyst\Middleware;

use Skoolyst\Core\Response;

class GuestMiddleware {
    public function handle(): void {
        if (is_authenticated()) {
            Response::redirect(safe_next_url(isset($_GET['next']) ? (string) $_GET['next'] : null) ?? route('home'));
        }
    }
}
