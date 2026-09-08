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

    public static function findBySlug(int $subjectId, string $slug, ?int $excludeId = null): ?array {
        $sql = 'SELECT * FROM mcq_topics WHERE subject_id = ? AND slug = ?';
        $params = [$subjectId, $slug];
        if ($excludeId !== null) {
            $sql .= ' AND id != ?';
            $params[] = $excludeId;
        }
        $stmt = Database::connection()->prepare($sql . ' LIMIT 1');
        $stmt->execute($params);
        $topic = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $topic ?: null;
    }

    public static function create(array $data): int {
        $stmt = Database::connection()->prepare(
            'INSERT INTO mcq_topics (subject_id, name, slug, description, icon, difficulty, created_at, updated_at)
             VALUES (:subject_id, :name, :slug, :description, :icon, :difficulty, NOW(), NOW())'
        );
        $stmt->execute([
            'subject_id' => $data['subject_id'],
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'] !== '' ? $data['description'] : null,
            'icon' => $data['icon'] !== '' ? $data['icon'] : null,
            'difficulty' => $data['difficulty'],
        ]);
        return (int) Database::connection()->lastInsertId();
    }

    public static function update(int $id, array $data): void {
        $stmt = Database::connection()->prepare(
            'UPDATE mcq_topics
             SET subject_id = :subject_id, name = :name, slug = :slug, description = :description,
                 icon = :icon, difficulty = :difficulty, updated_at = NOW()
             WHERE id = :id'
        );
        $stmt->execute([
            'subject_id' => $data['subject_id'],
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'] !== '' ? $data['description'] : null,
            'icon' => $data['icon'] !== '' ? $data['icon'] : null,
            'difficulty' => $data['difficulty'],
            'id' => $id,
        ]);
    }

    public static function delete(int $id): void {
        $stmt = Database::connection()->prepare('DELETE FROM mcq_topics WHERE id = ?');
        $stmt->execute([$id]);
    }

    public static function mcqCount(int $id): int {
        $stmt = Database::connection()->prepare('SELECT COUNT(*) FROM mcq_questions WHERE topic_id = ?');
        $stmt->execute([$id]);
        return (int) $stmt->fetchColumn();
    }

    public static function forSubject(int $subjectId): array {
        $stmt = Database::connection()->prepare(
            'SELECT t.*, COUNT(q.id) AS mcq_count
             FROM mcq_topics t
             LEFT JOIN mcq_questions q ON q.topic_id = t.id
             WHERE t.subject_id = ?
             GROUP BY t.id
             ORDER BY t.name ASC'
        );
        $stmt->execute([$subjectId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
