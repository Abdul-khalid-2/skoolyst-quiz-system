<?php
declare(strict_types=1);

namespace Skoolyst\Models;

use Skoolyst\Core\Database;
use Skoolyst\Core\Model;

class MockTest extends Model {
    protected string $table = 'mcq_mock_tests';
    protected array $fillable = [
        'test_type_id', 'title', 'slug', 'description', 'total_questions',
        'duration_minutes', 'difficulty', 'passing_score_percent', 'negative_marking', 'is_featured',
    ];

    public static function all(): array {
        return Database::connection()->query(
            'SELECT mcq_mock_tests.*, mcq_test_types.name AS test_type_name
             FROM mcq_mock_tests
             JOIN mcq_test_types ON mcq_test_types.id = mcq_mock_tests.test_type_id
             ORDER BY mcq_mock_tests.created_at DESC'
        )->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function count(): int {
        return (int) Database::connection()->query('SELECT COUNT(*) FROM mcq_mock_tests')->fetchColumn();
    }

    public static function find(int $id): ?array {
        $stmt = Database::connection()->prepare('SELECT * FROM mcq_mock_tests WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $mockTest = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $mockTest ?: null;
    }

    public static function findBySlug(string $slug, ?int $excludeId = null): ?array {
        $sql = 'SELECT * FROM mcq_mock_tests WHERE slug = ?';
        $params = [$slug];
        if ($excludeId !== null) {
            $sql .= ' AND id != ?';
            $params[] = $excludeId;
        }
        $stmt = Database::connection()->prepare($sql . ' LIMIT 1');
        $stmt->execute($params);
        $mockTest = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $mockTest ?: null;
    }

    public static function create(array $data): int {
        $stmt = Database::connection()->prepare(
            'INSERT INTO mcq_mock_tests
             (test_type_id, title, slug, description, total_questions, duration_minutes, difficulty, passing_score_percent, negative_marking, is_featured, created_at, updated_at)
             VALUES (:test_type_id, :title, :slug, :description, :total_questions, :duration_minutes, :difficulty, :passing_score_percent, :negative_marking, :is_featured, NOW(), NOW())'
        );
        $stmt->execute(self::bindData($data));
        return (int) Database::connection()->lastInsertId();
    }

    public static function update(int $id, array $data): void {
        $stmt = Database::connection()->prepare(
            'UPDATE mcq_mock_tests
             SET test_type_id = :test_type_id, title = :title, slug = :slug, description = :description,
                 total_questions = :total_questions, duration_minutes = :duration_minutes, difficulty = :difficulty,
                 passing_score_percent = :passing_score_percent, negative_marking = :negative_marking,
                 is_featured = :is_featured, updated_at = NOW()
             WHERE id = :id'
        );
        $stmt->execute(self::bindData($data) + ['id' => $id]);
    }

    private static function bindData(array $data): array {
        return [
            'test_type_id' => $data['test_type_id'],
            'title' => $data['title'],
            'slug' => $data['slug'],
            'description' => $data['description'] !== '' ? $data['description'] : null,
            'total_questions' => $data['total_questions'],
            'duration_minutes' => $data['duration_minutes'],
            'difficulty' => $data['difficulty'],
            'passing_score_percent' => $data['passing_score_percent'],
            'negative_marking' => $data['negative_marking'] ? 1 : 0,
            'is_featured' => $data['is_featured'] ? 1 : 0,
        ];
    }

    public static function delete(int $id): void {
        $stmt = Database::connection()->prepare('DELETE FROM mcq_mock_tests WHERE id = ?');
        $stmt->execute([$id]);
    }

    public static function attemptCount(int $id): int {
        $stmt = Database::connection()->prepare('SELECT COUNT(*) FROM mcq_mock_test_attempts WHERE mock_test_id = ?');
        $stmt->execute([$id]);
        return (int) $stmt->fetchColumn();
    }

    public static function getQuestionIds(int $mockTestId): array {
        $stmt = Database::connection()->prepare(
            'SELECT mcq_id FROM mcq_mock_test_questions WHERE mock_test_id = ? ORDER BY sort_order ASC'
        );
        $stmt->execute([$mockTestId]);
        return array_map('intval', $stmt->fetchAll(\PDO::FETCH_COLUMN));
    }

    public static function linkedQuestionCount(int $mockTestId): int {
        $stmt = Database::connection()->prepare('SELECT COUNT(*) FROM mcq_mock_test_questions WHERE mock_test_id = ?');
        $stmt->execute([$mockTestId]);
        return (int) $stmt->fetchColumn();
    }

    /**
     * @param array<int, int> $mcqIds
     */
    public static function saveQuestions(int $mockTestId, array $mcqIds): void {
        $pdo = Database::connection();
        $pdo->prepare('DELETE FROM mcq_mock_test_questions WHERE mock_test_id = ?')->execute([$mockTestId]);

        $insert = $pdo->prepare(
            'INSERT INTO mcq_mock_test_questions (mock_test_id, mcq_id, sort_order) VALUES (?, ?, ?)'
        );

        foreach (array_values($mcqIds) as $order => $mcqId) {
            $insert->execute([$mockTestId, $mcqId, $order]);
        }
    }
}
