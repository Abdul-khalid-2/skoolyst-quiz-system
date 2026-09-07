<?php
declare(strict_types=1);

namespace Skoolyst\Models;

use Skoolyst\Core\Database;
use Skoolyst\Core\Model;

class Topic extends Model {
    protected string $table = 'mcq_topics';
    protected array $fillable = ['subject_id', 'name', 'slug', 'description', 'icon', 'difficulty'];

    public static function all(): array {
        return Database::connection()->query(
            'SELECT mcq_topics.*, mcq_subjects.name AS subject_name
             FROM mcq_topics
             JOIN mcq_subjects ON mcq_subjects.id = mcq_topics.subject_id
             ORDER BY mcq_subjects.name ASC, mcq_topics.name ASC'
        )->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function count(): int {
        return (int) Database::connection()->query('SELECT COUNT(*) FROM mcq_topics')->fetchColumn();
    }

    public static function allGroupedBySubject(): array {
        $grouped = [];
        foreach (self::all() as $topic) {
            $grouped[$topic['subject_name']][] = $topic;
        }
        return $grouped;
    }

    public static function find(int $id): ?array {
        $stmt = Database::connection()->prepare('SELECT * FROM mcq_topics WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $topic = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $topic ?: null;
    }
}
