<?php
declare(strict_types=1);

namespace Skoolyst\Models;

use Skoolyst\Core\Database;

class MockTestAttempt {
    /**
     * Creates a completed attempt in one shot (the client submits the whole test at once).
     */
    public static function record(int $userId, int $mockTestId, int $totalQuestions, int $correctCount, float $scorePercent, int $timeTakenSeconds): int {
        $pdo = Database::connection();
        $stmt = $pdo->prepare(
            'INSERT INTO mcq_mock_test_attempts
             (user_id, mock_test_id, total_questions, correct_count, score_percent, time_taken_seconds, started_at, completed_at)
             VALUES (?, ?, ?, ?, ?, ?, DATE_SUB(NOW(), INTERVAL ? SECOND), NOW())'
        );
        $stmt->execute([$userId, $mockTestId, $totalQuestions, $correctCount, $scorePercent, $timeTakenSeconds, $timeTakenSeconds]);
        return (int) $pdo->lastInsertId();
    }

    public static function saveAnswer(int $attemptId, int $mcqId, ?int $optionId, bool $isCorrect, bool $marked): void {
        $stmt = Database::connection()->prepare(
            'INSERT INTO mcq_mock_test_attempt_answers
             (mock_test_attempt_id, mcq_id, selected_option_id, is_correct, is_marked_for_review, answered_at)
             VALUES (?, ?, ?, ?, ?, NOW())'
        );
        $stmt->execute([$attemptId, $mcqId, $optionId, $isCorrect ? 1 : 0, $marked ? 1 : 0]);
    }

    public static function find(int $id): ?array {
        $stmt = Database::connection()->prepare(
            'SELECT a.*, m.title, m.slug, m.duration_minutes, m.passing_score_percent
             FROM mcq_mock_test_attempts a
             JOIN mcq_mock_tests m ON m.id = a.mock_test_id
             WHERE a.id = ? LIMIT 1'
        );
        $stmt->execute([$id]);
        $attempt = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $attempt ?: null;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function answers(int $attemptId): array {
        $stmt = Database::connection()->prepare(
            'SELECT aa.*, q.question_text, q.explanation, q.difficulty, s.name AS subject_name
             FROM mcq_mock_test_attempt_answers aa
             JOIN mcq_questions q ON q.id = aa.mcq_id
             JOIN mcq_subjects s ON s.id = q.subject_id
             WHERE aa.mock_test_attempt_id = ?
             ORDER BY aa.id ASC'
        );
        $stmt->execute([$attemptId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @return array<int, array<string, mixed>> Most recent attempts for a user on a given mock test.
     */
    public static function forUserAndMockTest(int $userId, int $mockTestId, int $limit = 5): array {
        $stmt = Database::connection()->prepare(
            'SELECT * FROM mcq_mock_test_attempts
             WHERE user_id = ? AND mock_test_id = ?
             ORDER BY completed_at DESC
             LIMIT ' . (int) $limit
        );
        $stmt->execute([$userId, $mockTestId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
