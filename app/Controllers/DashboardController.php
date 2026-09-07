<?php
declare(strict_types=1);

namespace Skoolyst\Controllers;

use Skoolyst\Core\Controller;

class DashboardController extends Controller {
    public function index(): void {
        $this->view('admin.dashboard');
    }
}
