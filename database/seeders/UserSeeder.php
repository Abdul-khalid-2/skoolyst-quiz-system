<?php
declare(strict_types=1);

use Skoolyst\Models\User;

// Demo login for local development: skoolyst@gmail.com / password
return function (PDO $pdo): void {
    if (User::findByEmail('skoolyst@gmail.com') === null) {
        User::create('Admin User', 'skoolyst@gmail.com', password_hash('password', PASSWORD_DEFAULT), 'admin');
    }
};
