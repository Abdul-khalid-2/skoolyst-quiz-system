<?php
// Public/frontend browser routes.

use Skoolyst\Controllers\HomeController;

$router->get('/', [HomeController::class, 'index']);
