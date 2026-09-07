<?php
declare(strict_types=1);

namespace Skoolyst\Models;

use Skoolyst\Core\Database;
use Skoolyst\Core\Model;

class Mcq extends Model {
    protected string $table = 'mcq_questions';
    protected array $fillable = ['subject_id', 'topic_id', 'question_text', 'explanation', 'difficulty'];

    public static function all(int $limit = 50): array {
        $stmt = Database::connection()->prepare(
            'SELECT mcq_questions.*, mcq_subjects.name AS subject_name, mcq_topics.name AS topic_name
             FROM mcq_questions
             JOIN mcq_subjects ON mcq_subjects.id = mcq_questions.subject_id
             LEFT JOIN mcq_topics ON mcq_topics.id = mcq_questions.topic_id
             ORDER BY mcq_questions.created_at DESC
             LIMIT ?'
        );
        $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function count(): int {
        return (int) Database::connection()->query('SELECT COUNT(*) FROM mcq_questions')->fetchColumn();
    }
}
