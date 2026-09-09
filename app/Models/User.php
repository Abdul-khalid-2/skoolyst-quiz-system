<?php
declare(strict_types=1);

namespace Skoolyst\Models;

use Skoolyst\Core\Database;
use Skoolyst\Core\Model;

class User extends Model {
    protected string $table = 'mcq_users';
    protected array $fillable = ['name', 'email', 'password', 'role'];

    public static function findByEmail(string $email): ?array {
        $stmt = Database::connection()->prepare('SELECT * FROM mcq_users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public static function findById(int $id): ?array {
        $stmt = Database::connection()->prepare('SELECT * FROM mcq_users WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public static function updatePassword(int $id, string $passwordHash): void {
        $stmt = Database::connection()->prepare('UPDATE mcq_users SET password = ?, updated_at = NOW() WHERE id = ?');
        $stmt->execute([$passwordHash, $id]);
    }

    public static function create(string $name, string $email, string $passwordHash, string $role = 'user'): array {
        $stmt = Database::connection()->prepare(
            'INSERT INTO mcq_users (name, email, password, role, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())'
        );
        $stmt->execute([$name, $email, $passwordHash, $role]);

        return [
            'id' => (int) Database::connection()->lastInsertId(),
            'name' => $name,
            'email' => $email,
            'role' => $role,
        ];
    }
}
