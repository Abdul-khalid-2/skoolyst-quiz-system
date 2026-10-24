<?php
declare(strict_types=1);

namespace Skoolyst\Models;

use Skoolyst\Core\Database;
use Skoolyst\Core\Model;

class Mcq extends Model {
    protected string $table = 'mcq_questions';
    protected array $fillable = ['subject_id', 'topic_id', 'question_text', 'explanation', 'difficulty'];

    public static function all(?int $limit = null): array {
        $sql = 'SELECT mcq_questions.*, mcq_subjects.name AS subject_name, mcq_topics.name AS topic_name
             FROM mcq_questions
             JOIN mcq_subjects ON mcq_subjects.id = mcq_questions.subject_id
             LEFT JOIN mcq_topics ON mcq_topics.id = mcq_questions.topic_id
             ORDER BY mcq_questions.created_at DESC';

        if ($limit === null) {
            return Database::connection()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
        }

        $stmt = Database::connection()->prepare($sql . ' LIMIT ?');
        $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * One page of MCQs for the admin list, with optional filters.
     *
     * Filters: q (text in the question, or an exact MCQ id), subject_id, topic_id ('none' = no topic),
     * difficulty (easy|medium|hard).
     *
     * @param array{q?: string, subject_id?: int, topic_id?: int|string, difficulty?: string} $filters
     * @return array{items: array<int, array<string, mixed>>, total: int, page: int, pages: int, per_page: int, from: int, to: int}
     */
    public static function paginate(array $filters, int $page, int $perPage): array {
        $perPage = max(1, min(200, $perPage));
        $where = [];
        $params = [];

        $q = trim((string) ($filters['q'] ?? ''));
        if ($q !== '') {
            // Escape LIKE wildcards so searching for "50%" or "a_b" matches literally.
            $like = '%' . str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $q) . '%';
            if (ctype_digit($q)) {
                $where[] = '(q.question_text LIKE :q_text OR q.id = :q_id)';
                $params['q_id'] = (int) $q;
            } else {
                $where[] = 'q.question_text LIKE :q_text';
            }
            $params['q_text'] = $like;
        }

        $subjectId = (int) ($filters['subject_id'] ?? 0);
        if ($subjectId > 0) {
            $where[] = 'q.subject_id = :subject_id';
            $params['subject_id'] = $subjectId;
        }

        $topic = $filters['topic_id'] ?? 0;
        if ($topic === 'none') {
            $where[] = '(q.topic_id IS NULL OR q.topic_id = 0)';
        } elseif ((int) $topic > 0) {
            $where[] = 'q.topic_id = :topic_id';
            $params['topic_id'] = (int) $topic;
        }

        $difficulty = (string) ($filters['difficulty'] ?? '');
        if (in_array($difficulty, ['easy', 'medium', 'hard'], true)) {
            $where[] = 'q.difficulty = :difficulty';
            $params['difficulty'] = $difficulty;
        }

        $whereSql = $where ? ' WHERE ' . implode(' AND ', $where) : '';
        $db = Database::connection();

        $countStmt = $db->prepare('SELECT COUNT(*) FROM mcq_questions q' . $whereSql);
        $countStmt->execute($params);
        $total = (int) $countStmt->fetchColumn();

        $pages = max(1, (int) ceil($total / $perPage));
        $page = max(1, min($page, $pages));
        $offset = ($page - 1) * $perPage;

        // id is a tie-breaker so rows never repeat or vanish between pages.
        $stmt = $db->prepare(
            'SELECT q.*, s.name AS subject_name, t.name AS topic_name
             FROM mcq_questions q
             JOIN mcq_subjects s ON s.id = q.subject_id
             LEFT JOIN mcq_topics t ON t.id = q.topic_id'
            . $whereSql .
            ' ORDER BY q.created_at DESC, q.id DESC
             LIMIT :limit OFFSET :offset'
        );
        foreach ($params as $name => $value) {
            $stmt->bindValue(':' . $name, $value, is_int($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR);
        }
        $stmt->bindValue(':limit', $perPage, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();

        $items = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return [
            'items' => $items,
            'total' => $total,
            'page' => $page,
            'pages' => $pages,
            'per_page' => $perPage,
            'from' => $total === 0 ? 0 : $offset + 1,
            'to' => $offset + count($items),
        ];
    }

    public static function count(): int {
        return (int) Database::connection()->query('SELECT COUNT(*) FROM mcq_questions')->fetchColumn();
    }

    public static function search(string $term, int $limit = 8): array {
        $stmt = Database::connection()->prepare(
            'SELECT q.*, s.name AS subject_name, s.slug AS subject_slug, t.name AS topic_name, t.slug AS topic_slug
             FROM mcq_questions q
             JOIN mcq_subjects s ON s.id = q.subject_id
             LEFT JOIN mcq_topics t ON t.id = q.topic_id
             WHERE q.question_text LIKE :term
             ORDER BY q.created_at DESC
             LIMIT ' . (int) $limit
        );
        $stmt->execute(['term' => '%' . $term . '%']);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function find(int $id): ?array {
        $stmt = Database::connection()->prepare('SELECT * FROM mcq_questions WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $mcq = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $mcq ?: null;
    }

    public static function create(array $data): int {
        $stmt = Database::connection()->prepare(
            'INSERT INTO mcq_questions (subject_id, topic_id, question_text, explanation, difficulty, created_at, updated_at)
             VALUES (:subject_id, :topic_id, :question_text, :explanation, :difficulty, NOW(), NOW())'
        );
        $stmt->execute([
            'subject_id' => $data['subject_id'],
            'topic_id' => $data['topic_id'] ?: null,
            'question_text' => $data['question_text'],
            'explanation' => $data['explanation'] !== '' ? $data['explanation'] : null,
            'difficulty' => $data['difficulty'],
        ]);
        return (int) Database::connection()->lastInsertId();
    }

    public static function update(int $id, array $data): void {
        $stmt = Database::connection()->prepare(
            'UPDATE mcq_questions
             SET subject_id = :subject_id, topic_id = :topic_id, question_text = :question_text,
                 explanation = :explanation, difficulty = :difficulty, updated_at = NOW()
             WHERE id = :id'
        );
        $stmt->execute([
            'subject_id' => $data['subject_id'],
            'topic_id' => $data['topic_id'] ?: null,
            'question_text' => $data['question_text'],
            'explanation' => $data['explanation'] !== '' ? $data['explanation'] : null,
            'difficulty' => $data['difficulty'],
            'id' => $id,
        ]);
    }

    public static function delete(int $id): void {
        $stmt = Database::connection()->prepare('DELETE FROM mcq_questions WHERE id = ?');
        $stmt->execute([$id]);
    }

    public static function forTopic(int $topicId): array {
        $stmt = Database::connection()->prepare(
            'SELECT * FROM mcq_questions WHERE topic_id = ? ORDER BY created_at ASC'
        );
        $stmt->execute([$topicId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Normalize question text for duplicate comparison: trim, collapse whitespace, lowercase.
     */
    public static function normalizeQuestionText(string $text): string {
        return mb_strtolower(trim(preg_replace('/\s+/u', ' ', $text) ?? $text));
    }

    /**
     * @return array<string, true> Set of normalized question texts already stored for this topic.
     */
    public static function normalizedQuestionTextsForTopic(int $topicId): array {
        $stmt = Database::connection()->prepare('SELECT question_text FROM mcq_questions WHERE topic_id = ?');
        $stmt->execute([$topicId]);

        $normalized = [];
        foreach ($stmt->fetchAll(\PDO::FETCH_COLUMN) as $text) {
            $normalized[self::normalizeQuestionText((string) $text)] = true;
        }
        return $normalized;
    }

    /**
     * @param array<int, array{label: string, text: string, correct: bool}> $options
     */
    public static function createWithOptions(int $subjectId, int $topicId, string $questionText, ?string $explanation, string $difficulty, array $options): int {
        $id = self::create([
            'subject_id' => $subjectId,
            'topic_id' => $topicId,
            'question_text' => $questionText,
            'explanation' => $explanation ?? '',
            'difficulty' => $difficulty,
        ]);
        self::saveOptions($id, $options);
        return $id;
    }

    public static function getOptions(int $mcqId): array {
        $stmt = Database::connection()->prepare('SELECT * FROM mcq_options WHERE mcq_id = ? ORDER BY sort_order ASC');
        $stmt->execute([$mcqId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Batch-loads options for many MCQs in a single query, grouped by mcq_id.
     *
     * @param array<int, int> $mcqIds
     * @return array<int, array<int, array<string, mixed>>>
     */
    public static function getOptionsForMany(array $mcqIds): array {
        $grouped = [];
        if (empty($mcqIds)) return $grouped;

        $placeholders = implode(',', array_fill(0, count($mcqIds), '?'));
        $stmt = Database::connection()->prepare(
            "SELECT * FROM mcq_options WHERE mcq_id IN ($placeholders) ORDER BY mcq_id ASC, sort_order ASC"
        );
        $stmt->execute(array_values($mcqIds));

        foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $option) {
            $grouped[(int) $option['mcq_id']][] = $option;
        }
        return $grouped;
    }

    /**
     * @param array<int, array{label: string, text: string, correct: bool}> $options
     */
    public static function saveOptions(int $mcqId, array $options): void {
        $pdo = Database::connection();
        $pdo->prepare('DELETE FROM mcq_options WHERE mcq_id = ?')->execute([$mcqId]);

        $insert = $pdo->prepare(
            'INSERT INTO mcq_options (mcq_id, label, option_text, is_correct, sort_order) VALUES (?, ?, ?, ?, ?)'
        );

        foreach ($options as $order => $option) {
            $insert->execute([$mcqId, $option['label'], $option['text'], $option['correct'] ? 1 : 0, $order]);
        }
    }
}
