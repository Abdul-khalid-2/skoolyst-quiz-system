<?php
// Public/frontend browser routes.

use Skoolyst\Controllers\PageController;
use Skoolyst\Controllers\DashboardController;
use Skoolyst\Controllers\AuthController;
use Skoolyst\Controllers\Admin\McqController;
use Skoolyst\Controllers\Admin\SubjectController;
use Skoolyst\Controllers\Admin\TopicController;
use Skoolyst\Controllers\Admin\TestTypeController;
use Skoolyst\Controllers\Admin\MockTestController;
use Skoolyst\Middleware\GuestMiddleware;
use Skoolyst\Middleware\AdminMiddleware;

$router->get('/', [PageController::class, 'home'])->name('home');
$router->get('/sitemap.xml', [PageController::class, 'sitemap'])->name('sitemap');

$router->get('/search', [PageController::class, 'search'])->name('search');
$router->get('/search/api', [PageController::class, 'searchApi'])->name('search.api');

$router->get('/subjects', [PageController::class, 'subjectsIndex'])->name('subjects.index');
$router->get('/subjects/{slug}', [PageController::class, 'subjectsShow'])->name('subjects.show');

$router->get('/test-types', [PageController::class, 'testTypesIndex'])->name('test-types.index');
$router->get('/test-types/{slug}', [PageController::class, 'testTypesShow'])->name('test-types.show');
$router->get('/test-types/{testType}/subjects/{subject}', [PageController::class, 'testTypeSubject'])->name('test-types.subject');
$router->get('/test-types/{testType}/subjects/{subject}/topics/{topic}', [PageController::class, 'testTypeSubjectTopic'])->name('test-types.subject.topic');

$router->get('/topics/{slug}', [PageController::class, 'topicsShow'])->name('topics.show');
$router->get('/topics/{slug}/result', [PageController::class, 'topicsResult'])->name('topics.result');

$router->get('/practice/{slug}', [PageController::class, 'practice'])->name('practice.show');

$router->get('/mock-tests', [PageController::class, 'mockTestsIndex'])->name('mock-tests.index');
$router->get('/mock-tests/{slug}', [PageController::class, 'mockTestsShow'])->name('mock-tests.show');
$router->get('/mock-tests/{slug}/take', [PageController::class, 'mockTestsTake'])->name('mock-tests.take');
$router->get('/mock-tests/{slug}/result', [PageController::class, 'mockTestsResult'])->name('mock-tests.result');

$router->get('/dashboard', [DashboardController::class, 'index'], [AdminMiddleware::class])->name('dashboard');

$router->get('/dashboard/mcqs', [McqController::class, 'index'], [AdminMiddleware::class])->name('dashboard.mcqs');
$router->get('/dashboard/mcqs/create', [McqController::class, 'create'], [AdminMiddleware::class])->name('dashboard.mcqs.create');
$router->post('/dashboard/mcqs/create', [McqController::class, 'store'], [AdminMiddleware::class]);
$router->get('/dashboard/mcqs/{id}/edit', [McqController::class, 'edit'], [AdminMiddleware::class])->name('dashboard.mcqs.edit');
$router->post('/dashboard/mcqs/{id}/edit', [McqController::class, 'update'], [AdminMiddleware::class]);
$router->post('/dashboard/mcqs/{id}/delete', [McqController::class, 'destroy'], [AdminMiddleware::class])->name('dashboard.mcqs.delete');

$router->get('/dashboard/subjects', [SubjectController::class, 'index'], [AdminMiddleware::class])->name('dashboard.subjects');
$router->get('/dashboard/subjects/create', [SubjectController::class, 'create'], [AdminMiddleware::class])->name('dashboard.subjects.create');
$router->post('/dashboard/subjects/create', [SubjectController::class, 'store'], [AdminMiddleware::class]);
$router->get('/dashboard/subjects/{id}/edit', [SubjectController::class, 'edit'], [AdminMiddleware::class])->name('dashboard.subjects.edit');
$router->post('/dashboard/subjects/{id}/edit', [SubjectController::class, 'update'], [AdminMiddleware::class]);
$router->post('/dashboard/subjects/{id}/delete', [SubjectController::class, 'destroy'], [AdminMiddleware::class])->name('dashboard.subjects.delete');

$router->get('/dashboard/topics', [TopicController::class, 'index'], [AdminMiddleware::class])->name('dashboard.topics');
$router->get('/dashboard/topics/create', [TopicController::class, 'create'], [AdminMiddleware::class])->name('dashboard.topics.create');
$router->post('/dashboard/topics/create', [TopicController::class, 'store'], [AdminMiddleware::class]);
$router->get('/dashboard/topics/{id}/edit', [TopicController::class, 'edit'], [AdminMiddleware::class])->name('dashboard.topics.edit');
$router->post('/dashboard/topics/{id}/edit', [TopicController::class, 'update'], [AdminMiddleware::class]);
$router->post('/dashboard/topics/{id}/delete', [TopicController::class, 'destroy'], [AdminMiddleware::class])->name('dashboard.topics.delete');

$router->get('/dashboard/test-types', [TestTypeController::class, 'index'], [AdminMiddleware::class])->name('dashboard.test-types');
$router->get('/dashboard/test-types/create', [TestTypeController::class, 'create'], [AdminMiddleware::class])->name('dashboard.test-types.create');
$router->post('/dashboard/test-types/create', [TestTypeController::class, 'store'], [AdminMiddleware::class]);
$router->get('/dashboard/test-types/{id}/edit', [TestTypeController::class, 'edit'], [AdminMiddleware::class])->name('dashboard.test-types.edit');
$router->post('/dashboard/test-types/{id}/edit', [TestTypeController::class, 'update'], [AdminMiddleware::class]);
$router->post('/dashboard/test-types/{id}/delete', [TestTypeController::class, 'destroy'], [AdminMiddleware::class])->name('dashboard.test-types.delete');

$router->get('/dashboard/mock-tests', [MockTestController::class, 'index'], [AdminMiddleware::class])->name('dashboard.mock-tests');
$router->get('/dashboard/mock-tests/create', [MockTestController::class, 'create'], [AdminMiddleware::class])->name('dashboard.mock-tests.create');
$router->post('/dashboard/mock-tests/create', [MockTestController::class, 'store'], [AdminMiddleware::class]);
$router->get('/dashboard/mock-tests/{id}/edit', [MockTestController::class, 'edit'], [AdminMiddleware::class])->name('dashboard.mock-tests.edit');
$router->post('/dashboard/mock-tests/{id}/edit', [MockTestController::class, 'update'], [AdminMiddleware::class]);
$router->post('/dashboard/mock-tests/{id}/delete', [MockTestController::class, 'destroy'], [AdminMiddleware::class])->name('dashboard.mock-tests.delete');

$router->get('/dashboard/account', [DashboardController::class, 'account'], [AdminMiddleware::class])->name('dashboard.account');
$router->post('/dashboard/account', [DashboardController::class, 'updateAccount'], [AdminMiddleware::class]);
$router->get('/dashboard/settings', [DashboardController::class, 'settings'], [AdminMiddleware::class])->name('dashboard.settings');

$router->get('/dashboard/settings/mcqs/{id}/export', [DashboardController::class, 'exportMcqTopic'], [AdminMiddleware::class])->name('dashboard.settings.mcqs.export');
$router->post('/dashboard/settings/mcqs/import/preview', [DashboardController::class, 'importMcqPreview'], [AdminMiddleware::class])->name('dashboard.settings.mcqs.import.preview');
$router->post('/dashboard/settings/mcqs/import/confirm', [DashboardController::class, 'importMcqConfirm'], [AdminMiddleware::class])->name('dashboard.settings.mcqs.import.confirm');

$router->get('/login', [AuthController::class, 'showLogin'], [GuestMiddleware::class])->name('login');
$router->post('/login', [AuthController::class, 'login'], [GuestMiddleware::class]);
$router->get('/register', [AuthController::class, 'showRegister'], [GuestMiddleware::class])->name('register');
$router->post('/register', [AuthController::class, 'register'], [GuestMiddleware::class]);
$router->get('/logout', [AuthController::class, 'logout'])->name('logout');
