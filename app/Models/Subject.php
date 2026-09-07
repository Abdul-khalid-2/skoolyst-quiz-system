<?php
declare(strict_types=1);

namespace Skoolyst\Models;

use Skoolyst\Core\Database;
use Skoolyst\Core\Model;

class Subject extends Model {
    protected string $table = 'subjects';
    protected array $fillable = ['name', 'slug', 'description', 'icon', 'icon_bg'];

    public static function all(): array {
        return Database::connection()
            ->query('SELECT * FROM subjects ORDER BY name ASC')
            ->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function count(): int {
        return (int) Database::connection()->query('SELECT COUNT(*) FROM subjects')->fetchColumn();
    }
}
