<?php
declare(strict_types=1);

namespace Skoolyst\Models;

use Skoolyst\Core\Database;
use Skoolyst\Core\Model;

class TestType extends Model {
    protected string $table = 'test_types';
    protected array $fillable = ['name', 'slug', 'description', 'icon', 'badge_class'];

    public static function all(): array {
        return Database::connection()
            ->query('SELECT * FROM test_types ORDER BY name ASC')
            ->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function count(): int {
        return (int) Database::connection()->query('SELECT COUNT(*) FROM test_types')->fetchColumn();
    }
}
