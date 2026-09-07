<?php
declare(strict_types=1);

namespace Skoolyst\Controllers;

use Skoolyst\Core\Controller;
use Skoolyst\Core\Database;

class HomeController extends Controller {
    public function index(): void {
        $dbConnected = false;
        $dbError = null;

        try {
            Database::connection();
            $dbConnected = true;
        } catch (\Throwable $e) {
            $dbError = $e->getMessage();
        }

        $this->view('frontend/home', [
            'appName' => $_ENV['APP_NAME'] ?? 'Skoolyst Module',
            'appEnv' => $_ENV['APP_ENV'] ?? 'local',
            'dbConnected' => $dbConnected,
            'dbError' => $dbError,
        ]);
    }
}
