<?php
// Public/frontend browser routes.

use Skoolyst\Controllers\PageController;
use Skoolyst\Controllers\DashboardController;
use Skoolyst\Controllers\AuthController;
use Skoolyst\Controllers\Admin\McqController;
use Skoolyst\Middleware\GuestMiddleware;
use Skoolyst\Middleware\AuthMiddleware;

$router->get('/', [PageController::class, 'home'])->name('home');

$router->get('/subjects', [PageController::class, 'subjectsIndex'])->name('subjects.index');
$router->get('/subjects/{slug}', [PageController::class, 'subjectsShow'])->name('subjects.show');
$router->get('/subjects/{slug}/result', [PageController::class, 'subjectsResult'])->name('subjects.result');

$router->get('/test-types', [PageController::class, 'testTypesIndex'])->name('test-types.index');
$router->get('/test-types/{slug}', [PageController::class, 'testTypesShow'])->name('test-types.show');
$router->get('/test-types/{testType}/subjects/{subject}', [PageController::class, 'testTypeSubject'])->name('test-types.subject');

$router->get('/topics/{slug}', [PageController::class, 'topicsShow'])->name('topics.show');
$router->get('/topics/{slug}/result', [PageController::class, 'topicsResult'])->name('topics.result');

$router->get('/practice/{slug}', [PageController::class, 'practice'])->name('practice.show');

$router->get('/mock-tests', [PageController::class, 'mockTestsIndex'])->name('mock-tests.index');
$router->get('/mock-tests/{slug}', [PageController::class, 'mockTestsShow'])->name('mock-tests.show');
$router->get('/mock-tests/{slug}/take', [PageController::class, 'mockTestsTake'])->name('mock-tests.take');
$router->get('/mock-tests/{slug}/result', [PageController::class, 'mockTestsResult'])->name('mock-tests.result');

$router->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

$router->get('/dashboard/mcqs', [McqController::class, 'index'])->name('dashboard.mcqs');
$router->get('/dashboard/mcqs/create', [McqController::class, 'create'])->name('dashboard.mcqs.create');
$router->post('/dashboard/mcqs/create', [McqController::class, 'store']);
$router->get('/dashboard/mcqs/{id}/edit', [McqController::class, 'edit'])->name('dashboard.mcqs.edit');
$router->post('/dashboard/mcqs/{id}/edit', [McqController::class, 'update']);
$router->post('/dashboard/mcqs/{id}/delete', [McqController::class, 'destroy'])->name('dashboard.mcqs.delete');

$router->get('/dashboard/subjects', [DashboardController::class, 'subjects'])->name('dashboard.subjects');
$router->get('/dashboard/topics', [DashboardController::class, 'topics'])->name('dashboard.topics');
$router->get('/dashboard/test-types', [DashboardController::class, 'testTypes'])->name('dashboard.test-types');
$router->get('/dashboard/mock-tests', [DashboardController::class, 'mockTests'])->name('dashboard.mock-tests');

$router->get('/dashboard/account', [DashboardController::class, 'account'], [AuthMiddleware::class])->name('dashboard.account');
$router->get('/dashboard/settings', [DashboardController::class, 'settings'], [AuthMiddleware::class])->name('dashboard.settings');
$router->post('/dashboard/settings', [DashboardController::class, 'updateSettings'], [AuthMiddleware::class]);

$router->get('/login', [AuthController::class, 'showLogin'], [GuestMiddleware::class])->name('login');
$router->post('/login', [AuthController::class, 'login'], [GuestMiddleware::class]);
$router->get('/register', [AuthController::class, 'showRegister'], [GuestMiddleware::class])->name('register');
$router->post('/register', [AuthController::class, 'register'], [GuestMiddleware::class]);
$router->get('/logout', [AuthController::class, 'logout'])->name('logout');
