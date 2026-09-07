<?php
declare(strict_types=1);

namespace Skoolyst\Models;

use Skoolyst\Core\Database;
use Skoolyst\Core\Model;

class MockTest extends Model {
    protected string $table = 'mock_tests';
    protected array $fillable = [
        'test_type_id', 'title', 'slug', 'description', 'total_questions',
        'duration_minutes', 'difficulty', 'passing_score_percent', 'negative_marking', 'is_featured',
    ];

    public static function all(): array {
        return Database::connection()->query(
            'SELECT mock_tests.*, test_types.name AS test_type_name
             FROM mock_tests
             JOIN test_types ON test_types.id = mock_tests.test_type_id
             ORDER BY mock_tests.created_at DESC'
        )->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function count(): int {
        return (int) Database::connection()->query('SELECT COUNT(*) FROM mock_tests')->fetchColumn();
    }
}
