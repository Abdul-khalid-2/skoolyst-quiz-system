<?php
declare(strict_types=1);

namespace Skoolyst\Controllers;

use Skoolyst\Core\Controller;
use Skoolyst\Core\Response;
use Skoolyst\Core\Validator;
use Skoolyst\Services\AuthService;

class AuthController extends Controller {
    private AuthService $auth;

    public function __construct() {
        $this->auth = new AuthService();
    }

    public function showLogin(): void {
        $this->view('auth.login', ['errors' => [], 'old' => []]);
    }

    public function login(): void {
        if (!csrf_verify()) {
            $this->view('auth.login', ['errors' => ['_general' => 'Your session expired. Please try again.'], 'old' => []]);
            return;
        }

        $data = ['email' => trim((string) old('email')), 'password' => (string) old('password')];

        $errors = Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (empty($errors) && !$this->auth->attemptLogin($data['email'], $data['password'])) {
            $errors['_general'] = 'Invalid email or password.';
        }

        if (!empty($errors)) {
            $this->view('auth.login', ['errors' => $errors, 'old' => $data]);
            return;
        }

        Response::redirect(route('home'));
    }

    public function showRegister(): void {
        $this->view('auth.register', ['errors' => [], 'old' => []]);
    }

    public function register(): void {
        if (!csrf_verify()) {
            $this->view('auth.register', ['errors' => ['_general' => 'Your session expired. Please try again.'], 'old' => []]);
            return;
        }

        $data = [
            'name' => trim((string) old('name')),
            'email' => trim((string) old('email')),
            'password' => (string) old('password'),
            'password_confirmation' => (string) old('password_confirmation'),
        ];

        $errors = Validator::make($data, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        if (empty($errors)) {
            $errors = $this->auth->register($data['name'], $data['email'], $data['password']);
        }

        if (!empty($errors)) {
            $this->view('auth.register', ['errors' => $errors, 'old' => $data]);
            return;
        }

        Response::redirect(route('home'));
    }

    public function logout(): void {
        $this->auth->logout();
        Response::redirect(route('home'));
    }
}
