<?php
declare(strict_types=1);

namespace Skoolyst\Controllers;

use Skoolyst\Core\Controller;
use Skoolyst\Core\Validator;
use Skoolyst\Models\User;

class DashboardController extends Controller {
    public function index(): void {
        $this->view('admin.dashboard');
    }

    public function account(): void {
        $this->view('admin.account', ['user' => User::findById(auth_user()['id'])]);
    }

    public function settings(): void {
        $this->view('admin.settings', ['errors' => []]);
    }

    public function updateSettings(): void {
        if (!csrf_verify()) {
            $this->view('admin.settings', ['errors' => ['_general' => 'Your session expired. Please try again.']]);
            return;
        }

        $data = [
            'current_password' => (string) old('current_password'),
            'password' => (string) old('password'),
            'password_confirmation' => (string) old('password_confirmation'),
        ];

        $errors = Validator::make($data, [
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::findById(auth_user()['id']);

        if (empty($errors) && !password_verify($data['current_password'], $user['password'])) {
            $errors['current_password'] = 'The current password is incorrect.';
        }

        if (!empty($errors)) {
            $this->view('admin.settings', ['errors' => $errors]);
            return;
        }

        User::updatePassword($user['id'], password_hash($data['password'], PASSWORD_DEFAULT));
        $this->view('admin.settings', ['errors' => [], 'success' => 'Your password has been updated.']);
    }
}
