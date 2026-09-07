<?php
declare(strict_types=1);

namespace Skoolyst\Models;

use Skoolyst\Core\Database;
use Skoolyst\Core\Model;

class Subject extends Model {
    protected string $table = 'mcq_subjects';
    protected array $fillable = ['name', 'slug', 'description', 'icon', 'icon_bg'];

    public static function all(): array {
        return Database::connection()
            ->query('SELECT * FROM mcq_subjects ORDER BY name ASC')
            ->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function count(): int {
        return (int) Database::connection()->query('SELECT COUNT(*) FROM mcq_subjects')->fetchColumn();
    }

    public static function find(int $id): ?array {
        $stmt = Database::connection()->prepare('SELECT * FROM mcq_subjects WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $subject = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $subject ?: null;
    }
}
