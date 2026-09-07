<?php
declare(strict_types=1);

namespace Skoolyst\Models;

use Skoolyst\Core\Database;
use Skoolyst\Core\Model;

class Subject extends Model {
    protected string $table = 'mcq_subjects';
    protected array $fillable = ['name', 'slug', 'description', 'icon', 'icon_bg'];

    public static function all(): array {
        return Database::connection()
            ->query('SELECT * FROM mcq_subjects ORDER BY name ASC')
            ->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function count(): int {
        return (int) Database::connection()->query('SELECT COUNT(*) FROM mcq_subjects')->fetchColumn();
    }

    public static function find(int $id): ?array {
        $stmt = Database::connection()->prepare('SELECT * FROM mcq_subjects WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $subject = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $subject ?: null;
    }

    public static function findBySlug(string $slug, ?int $excludeId = null): ?array {
        $sql = 'SELECT * FROM mcq_subjects WHERE slug = ?';
        $params = [$slug];
        if ($excludeId !== null) {
            $sql .= ' AND id != ?';
            $params[] = $excludeId;
        }
        $stmt = Database::connection()->prepare($sql . ' LIMIT 1');
        $stmt->execute($params);
        $subject = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $subject ?: null;
    }

    public static function create(array $data): int {
        $stmt = Database::connection()->prepare(
            'INSERT INTO mcq_subjects (name, slug, description, icon, icon_bg, created_at, updated_at)
             VALUES (:name, :slug, :description, :icon, :icon_bg, NOW(), NOW())'
        );
        $stmt->execute([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'] !== '' ? $data['description'] : null,
            'icon' => $data['icon'] !== '' ? $data['icon'] : null,
            'icon_bg' => $data['icon_bg'] !== '' ? $data['icon_bg'] : null,
        ]);
        return (int) Database::connection()->lastInsertId();
    }

    public static function update(int $id, array $data): void {
        $stmt = Database::connection()->prepare(
            'UPDATE mcq_subjects
             SET name = :name, slug = :slug, description = :description, icon = :icon, icon_bg = :icon_bg, updated_at = NOW()
             WHERE id = :id'
        );
        $stmt->execute([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'] !== '' ? $data['description'] : null,
            'icon' => $data['icon'] !== '' ? $data['icon'] : null,
            'icon_bg' => $data['icon_bg'] !== '' ? $data['icon_bg'] : null,
            'id' => $id,
        ]);
    }

    public static function delete(int $id): void {
        $stmt = Database::connection()->prepare('DELETE FROM mcq_subjects WHERE id = ?');
        $stmt->execute([$id]);
    }

    public static function topicCount(int $id): int {
        $stmt = Database::connection()->prepare('SELECT COUNT(*) FROM mcq_topics WHERE subject_id = ?');
        $stmt->execute([$id]);
        return (int) $stmt->fetchColumn();
    }

    public static function mcqCount(int $id): int {
        $stmt = Database::connection()->prepare('SELECT COUNT(*) FROM mcq_questions WHERE subject_id = ?');
        $stmt->execute([$id]);
        return (int) $stmt->fetchColumn();
    }
}
