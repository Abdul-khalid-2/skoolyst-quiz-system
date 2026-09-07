CREATE TABLE IF NOT EXISTS mcq_mock_tests (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    test_type_id INT UNSIGNED NOT NULL,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(200) NOT NULL,
    description TEXT NULL,
    total_questions SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    duration_minutes SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    difficulty ENUM('easy', 'medium', 'hard') NOT NULL DEFAULT 'medium',
    passing_score_percent TINYINT UNSIGNED NOT NULL DEFAULT 50,
    negative_marking TINYINT(1) NOT NULL DEFAULT 0,
    is_featured TINYINT(1) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_mcq_mock_tests_slug (slug),
    KEY idx_mcq_mock_tests_test_type (test_type_id),
    KEY idx_mcq_mock_tests_featured (is_featured),
    CONSTRAINT fk_mcq_mock_tests_test_type FOREIGN KEY (test_type_id) REFERENCES mcq_test_types (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
