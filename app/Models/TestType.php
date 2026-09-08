<?php
declare(strict_types=1);

namespace Skoolyst\Models;

use Skoolyst\Core\Database;
use Skoolyst\Core\Model;

class TestType extends Model {
    protected string $table = 'mcq_test_types';
    protected array $fillable = ['name', 'slug', 'description', 'icon', 'badge_class'];

    public static function all(): array {
        return Database::connection()
            ->query('SELECT * FROM mcq_test_types ORDER BY name ASC')
            ->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function count(): int {
        return (int) Database::connection()->query('SELECT COUNT(*) FROM mcq_test_types')->fetchColumn();
    }

    public static function allWithCounts(?int $limit = null): array {
        $sql = 'SELECT tt.*,
                       COUNT(DISTINCT stt.subject_id) AS subject_count,
                       COUNT(DISTINCT q.id) AS mcq_count
                FROM mcq_test_types tt
                LEFT JOIN mcq_subject_test_type stt ON stt.test_type_id = tt.id
                LEFT JOIN mcq_questions q ON q.subject_id = stt.subject_id
                GROUP BY tt.id
                ORDER BY mcq_count DESC, subject_count DESC, tt.name ASC';

        if ($limit !== null) {
            $sql .= ' LIMIT ' . (int) $limit;
        }

        return Database::connection()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function find(int $id): ?array {
        $stmt = Database::connection()->prepare('SELECT * FROM mcq_test_types WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $testType = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $testType ?: null;
    }

    public static function findBySlug(string $slug, ?int $excludeId = null): ?array {
        $sql = 'SELECT * FROM mcq_test_types WHERE slug = ?';
        $params = [$slug];
        if ($excludeId !== null) {
            $sql .= ' AND id != ?';
            $params[] = $excludeId;
        }
        $stmt = Database::connection()->prepare($sql . ' LIMIT 1');
        $stmt->execute($params);
        $testType = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $testType ?: null;
    }

    public static function create(array $data): int {
        $stmt = Database::connection()->prepare(
            'INSERT INTO mcq_test_types (name, slug, description, icon, badge_class, created_at, updated_at)
             VALUES (:name, :slug, :description, :icon, :badge_class, NOW(), NOW())'
        );
        $stmt->execute([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'] !== '' ? $data['description'] : null,
            'icon' => $data['icon'] !== '' ? $data['icon'] : null,
            'badge_class' => $data['badge_class'] !== '' ? $data['badge_class'] : null,
        ]);
        return (int) Database::connection()->lastInsertId();
    }

    public static function update(int $id, array $data): void {
        $stmt = Database::connection()->prepare(
            'UPDATE mcq_test_types
             SET name = :name, slug = :slug, description = :description, icon = :icon, badge_class = :badge_class, updated_at = NOW()
             WHERE id = :id'
        );
        $stmt->execute([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'] !== '' ? $data['description'] : null,
            'icon' => $data['icon'] !== '' ? $data['icon'] : null,
            'badge_class' => $data['badge_class'] !== '' ? $data['badge_class'] : null,
            'id' => $id,
        ]);
    }

    public static function delete(int $id): void {
        $stmt = Database::connection()->prepare('DELETE FROM mcq_test_types WHERE id = ?');
        $stmt->execute([$id]);
    }

    public static function mockTestCount(int $id): int {
        $stmt = Database::connection()->prepare('SELECT COUNT(*) FROM mcq_mock_tests WHERE test_type_id = ?');
        $stmt->execute([$id]);
        return (int) $stmt->fetchColumn();
    }

    public static function relatedSubjects(int $id): array {
        $stmt = Database::connection()->prepare(
            'SELECT s.*, COUNT(DISTINCT q.id) AS mcq_count
             FROM mcq_subjects s
             JOIN mcq_subject_test_type stt ON stt.subject_id = s.id
             LEFT JOIN mcq_questions q ON q.subject_id = s.id
             WHERE stt.test_type_id = ?
             GROUP BY s.id
             ORDER BY mcq_count DESC, s.name ASC'
        );
        $stmt->execute([$id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function popularTopics(int $id, int $limit = 6): array {
        $stmt = Database::connection()->prepare(
            'SELECT t.*, s.name AS subject_name, s.slug AS subject_slug, COUNT(q.id) AS mcq_count
             FROM mcq_topics t
             JOIN mcq_subjects s ON s.id = t.subject_id
             JOIN mcq_subject_test_type stt ON stt.subject_id = s.id
             LEFT JOIN mcq_questions q ON q.topic_id = t.id
             WHERE stt.test_type_id = ?
             GROUP BY t.id
             ORDER BY mcq_count DESC, t.name ASC
             LIMIT ' . (int) $limit
        );
        $stmt->execute([$id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function mcqCount(int $id): int {
        $stmt = Database::connection()->prepare(
            'SELECT COUNT(DISTINCT q.id)
             FROM mcq_questions q
             JOIN mcq_subject_test_type stt ON stt.subject_id = q.subject_id
             WHERE stt.test_type_id = ?'
        );
        $stmt->execute([$id]);
        return (int) $stmt->fetchColumn();
    }

    public static function topicCount(int $id): int {
        $stmt = Database::connection()->prepare(
            'SELECT COUNT(DISTINCT t.id)
             FROM mcq_topics t
             JOIN mcq_subject_test_type stt ON stt.subject_id = t.subject_id
             WHERE stt.test_type_id = ?'
        );
        $stmt->execute([$id]);
        return (int) $stmt->fetchColumn();
    }

    public static function isLinkedToSubject(int $testTypeId, int $subjectId): bool {
        $stmt = Database::connection()->prepare(
            'SELECT 1 FROM mcq_subject_test_type WHERE test_type_id = ? AND subject_id = ? LIMIT 1'
        );
        $stmt->execute([$testTypeId, $subjectId]);
        return (bool) $stmt->fetchColumn();
    }
}
