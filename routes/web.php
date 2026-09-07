<?php
// Public/frontend browser routes.

use Skoolyst\Controllers\PageController;
use Skoolyst\Controllers\DashboardController;

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
