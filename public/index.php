<?php
declare(strict_types=1);
require dirname(__DIR__) . '/bootstrap/app.php';

use Skoolyst\Core\Session;
use Skoolyst\Core\Request;
use Skoolyst\Core\Router;

Session::start();

$router = new Router();

// API/admin routing can be selected by the application's front controller strategy.
require dirname(__DIR__) . '/routes/web.php';

$router->dispatch(Request::method(), Request::uri());
