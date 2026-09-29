<?php
declare(strict_types=1);

namespace Skoolyst\Services;

use Skoolyst\Models\User;

class AuthService {
    public function attemptLogin(string $email, string $password): bool {
        $user = User::findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            return false;
        }

        $this->startSession($user);
        return true;
    }

    public function register(string $name, string $email, string $password): array {
        if (User::findByEmail($email) !== null) {
            return ['email' => 'An account with this email already exists.'];
        }

        $user = User::create($name, $email, password_hash($password, PASSWORD_DEFAULT));
        $this->startSession($user);

        EmailService::send(
            $email,
            'Welcome to Skoolyst MCQs',
            "Hi {$name},\n\nYour Skoolyst MCQs account has been created successfully. You can now log in and start practicing.\n\nSkoolyst MCQs"
        );

        return [];
    }

    public function logout(): void {
        unset($_SESSION['user']);
    }

    private function startSession(array $user): void {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'] ?? 'user',
        ];
    }
}
