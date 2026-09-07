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
}
