<?php
declare(strict_types=1);

namespace Skoolyst\Controllers;

use Skoolyst\Core\Controller;
use Skoolyst\Core\Response;
use Skoolyst\Core\Validator;
use Skoolyst\Models\User;
use Skoolyst\Services\AuthService;
use Skoolyst\Services\EmailService;
use Skoolyst\Services\GoogleAuthService;
use Skoolyst\Services\SkoolystAuthService;

class AuthController extends Controller {
    private AuthService $auth;
    private SkoolystAuthService $skoolystAuth;
    private GoogleAuthService $googleAuth;

    public function __construct() {
        $this->auth = new AuthService();
        $this->skoolystAuth = new SkoolystAuthService();
        $this->googleAuth = new GoogleAuthService();
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

    public function redirectToSkoolyst(): void {
        if (!$this->skoolystAuth->isConfigured()) {
            $this->view('auth.login', [
                'errors' => ['_general' => 'Login with Skoolyst is not configured yet.'],
                'old' => [],
            ]);
            return;
        }

        Response::redirect($this->skoolystAuth->authorizeUrl());
    }

    public function handleSkoolystCallback(): void {
        if (isset($_GET['error'])) {
            $this->view('auth.login', [
                'errors' => ['_general' => 'Login with Skoolyst was cancelled.'],
                'old' => [],
            ]);
            return;
        }

        $code = (string) ($_GET['code'] ?? '');
        $state = (string) ($_GET['state'] ?? '');

        if ($code === '' || $state === '') {
            $this->view('auth.login', [
                'errors' => ['_general' => 'Invalid login response from Skoolyst.'],
                'old' => [],
            ]);
            return;
        }

        try {
            $data = $this->skoolystAuth->handleCallback($code, $state);
        } catch (\Throwable $e) {
            $this->view('auth.login', ['errors' => ['_general' => $e->getMessage()], 'old' => []]);
            return;
        }

        $remoteUser = $data['user'];
        $localUser = User::findBySkoolystId((int) $remoteUser['id']);
        $isNewAccount = false;

        if ($localUser === null) {
            // Link an existing local account with the same email instead of creating a duplicate.
            $localUser = User::findByEmail($remoteUser['email']);
            if ($localUser !== null) {
                User::linkSkoolystId((int) $localUser['id'], (int) $remoteUser['id']);
            } else {
                $localUser = User::createFromSkoolyst((int) $remoteUser['id'], $remoteUser['name'], $remoteUser['email']);
                $isNewAccount = true;
            }
        }

        $this->auth->loginAs($localUser);

        if ($isNewAccount) {
            EmailService::send(
                $remoteUser['email'],
                'Welcome to Skoolyst MCQs',
                "Hi {$remoteUser['name']},\n\nYour Skoolyst MCQs account has been created via Login with Skoolyst. You can now start practicing.\n\nSkoolyst MCQs"
            );
        }

        Response::redirect(route('home'));
    }

    public function redirectToGoogle(): void {
        if (!$this->googleAuth->isConfigured()) {
            $this->view('auth.login', [
                'errors' => ['_general' => 'Login with Google is not configured yet.'],
                'old' => [],
            ]);
            return;
        }

        Response::redirect($this->googleAuth->authorizeUrl());
    }

    public function handleGoogleCallback(): void {
        if (isset($_GET['error'])) {
            // User cancelled on Google's consent screen — not an error worth surfacing.
            Response::redirect(route('login'));
            return;
        }

        $code = (string) ($_GET['code'] ?? '');
        $state = (string) ($_GET['state'] ?? '');

        if ($code === '' || $state === '') {
            $this->view('auth.login', [
                'errors' => ['_general' => 'Invalid login response from Google.'],
                'old' => [],
            ]);
            return;
        }

        try {
            $identity = $this->googleAuth->handleCallback($code, $state);
        } catch (\Throwable $e) {
            $this->view('auth.login', ['errors' => ['_general' => $e->getMessage()], 'old' => []]);
            return;
        }

        $localUser = User::findByGoogleId($identity['id']);
        $isNewAccount = false;

        if ($localUser === null) {
            $existing = User::findByEmail($identity['email']);

            if ($existing !== null && $existing['google_id'] !== null && $existing['google_id'] !== $identity['id']) {
                // This email is already linked to a different Google account — don't silently take it over.
                $this->view('auth.login', [
                    'errors' => ['_general' => 'This email is already linked to a different Google account. Please sign in with your password instead.'],
                    'old' => [],
                ]);
                return;
            }

            if ($existing !== null) {
                if (!$identity['email_verified']) {
                    $this->view('auth.login', [
                        'errors' => ['_general' => 'An account with this email already exists. Please sign in with your password instead.'],
                        'old' => [],
                    ]);
                    return;
                }

                User::linkGoogleId((int) $existing['id'], $identity['id']);
                $localUser = $existing;
            } else {
                $localUser = User::createFromGoogle($identity['id'], $identity['name'], $identity['email']);
                $isNewAccount = true;
            }
        }

        $this->auth->loginAs($localUser);

        if ($isNewAccount) {
            EmailService::send(
                $identity['email'],
                'Welcome to Skoolyst MCQs',
                "Hi {$identity['name']},\n\nYour Skoolyst MCQs account has been created via Login with Google. You can now start practicing.\n\nSkoolyst MCQs"
            );
        }

        Response::redirect(route('home'));
    }
}
