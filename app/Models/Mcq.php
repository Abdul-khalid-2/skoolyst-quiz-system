<?php
declare(strict_types=1);

namespace Skoolyst\Models;

use Skoolyst\Core\Database;
use Skoolyst\Core\Model;

class Mcq extends Model {
    protected string $table = 'mcqs';
    protected array $fillable = ['subject_id', 'topic_id', 'question_text', 'explanation', 'difficulty'];

    public static function all(int $limit = 50): array {
        $stmt = Database::connection()->prepare(
            'SELECT mcqs.*, subjects.name AS subject_name, topics.name AS topic_name
             FROM mcqs
             JOIN subjects ON subjects.id = mcqs.subject_id
             LEFT JOIN topics ON topics.id = mcqs.topic_id
             ORDER BY mcqs.created_at DESC
             LIMIT ?'
        );
        $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function count(): int {
        return (int) Database::connection()->query('SELECT COUNT(*) FROM mcqs')->fetchColumn();
    }
}
