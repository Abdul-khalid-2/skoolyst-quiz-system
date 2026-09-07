<?php
declare(strict_types=1);

namespace Skoolyst\Models;

use Skoolyst\Core\Database;
use Skoolyst\Core\Model;

class Topic extends Model {
    protected string $table = 'topics';
    protected array $fillable = ['subject_id', 'name', 'slug', 'description', 'icon', 'difficulty'];

    public static function all(): array {
        return Database::connection()->query(
            'SELECT topics.*, subjects.name AS subject_name
             FROM topics
             JOIN subjects ON subjects.id = topics.subject_id
             ORDER BY subjects.name ASC, topics.name ASC'
        )->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function count(): int {
        return (int) Database::connection()->query('SELECT COUNT(*) FROM topics')->fetchColumn();
    }
}
