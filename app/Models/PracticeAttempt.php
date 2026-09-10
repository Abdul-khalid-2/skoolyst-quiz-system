<?php
declare(strict_types=1);

namespace Skoolyst\Models;

use Skoolyst\Core\Database;

class PracticeAttempt {
    /**
     * Records a completed practice session in one shot (the client submits the whole session at once).
     */
    public static function record(int $userId, ?int $subjectId, ?int $topicId, int $totalQuestions, int $correctCount, float $scorePercent): int {
        $pdo = Database::connection();
        $stmt = $pdo->prepare(
            'INSERT INTO mcq_practice_attempts
             (user_id, subject_id, topic_id, total_questions, correct_count, score_percent, started_at, completed_at)
             VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())'
        );
        $stmt->execute([$userId, $subjectId, $topicId, $totalQuestions, $correctCount, $scorePercent]);
        return (int) $pdo->lastInsertId();
    }

    public static function saveAnswer(int $attemptId, int $mcqId, ?int $optionId, bool $isCorrect): void {
        $stmt = Database::connection()->prepare(
            'INSERT INTO mcq_practice_attempt_answers
             (practice_attempt_id, mcq_id, selected_option_id, is_correct, answered_at)
             VALUES (?, ?, ?, ?, NOW())'
        );
        $stmt->execute([$attemptId, $mcqId, $optionId, $isCorrect ? 1 : 0]);
    }

    public static function mostRecentForTopic(int $userId, int $topicId): ?array {
        $stmt = Database::connection()->prepare(
            'SELECT * FROM mcq_practice_attempts
             WHERE user_id = ? AND topic_id = ?
             ORDER BY completed_at DESC
             LIMIT 1'
        );
        $stmt->execute([$userId, $topicId]);
        $attempt = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $attempt ?: null;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function answers(int $attemptId): array {
        $stmt = Database::connection()->prepare(
            'SELECT aa.*, q.question_text, q.explanation, q.difficulty
             FROM mcq_practice_attempt_answers aa
             JOIN mcq_questions q ON q.id = aa.mcq_id
             WHERE aa.practice_attempt_id = ?
             ORDER BY aa.id ASC'
        );
        $stmt->execute([$attemptId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
