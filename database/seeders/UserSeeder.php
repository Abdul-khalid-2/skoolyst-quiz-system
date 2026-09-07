<?php
declare(strict_types=1);

use Skoolyst\Models\User;

// Demo login for local development: admin@skoolyst.test / password
return function (PDO $pdo): void {
    if (User::findByEmail('admin@skoolyst.test') === null) {
        User::create('Admin User', 'admin@skoolyst.test', password_hash('password', PASSWORD_DEFAULT));
    }
};
