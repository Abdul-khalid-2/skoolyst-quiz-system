<?php
declare(strict_types=1);

namespace Skoolyst\Models;

use Skoolyst\Core\Database;
use Skoolyst\Core\Model;

class User extends Model {
    protected string $table = 'users';
    protected array $fillable = ['name', 'email', 'password'];

    public static function findByEmail(string $email): ?array {
        $stmt = Database::connection()->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public static function findById(int $id): ?array {
        $stmt = Database::connection()->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public static function updatePassword(int $id, string $passwordHash): void {
        $stmt = Database::connection()->prepare('UPDATE users SET password = ?, updated_at = NOW() WHERE id = ?');
        $stmt->execute([$passwordHash, $id]);
    }

    public static function create(string $name, string $email, string $passwordHash): array {
        $stmt = Database::connection()->prepare(
            'INSERT INTO users (name, email, password, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())'
        );
        $stmt->execute([$name, $email, $passwordHash]);

        return [
            'id' => (int) Database::connection()->lastInsertId(),
            'name' => $name,
            'email' => $email,
        ];
    }
}
