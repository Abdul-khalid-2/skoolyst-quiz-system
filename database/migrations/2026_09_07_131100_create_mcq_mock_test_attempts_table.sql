CREATE TABLE IF NOT EXISTS mcq_mock_test_attempts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    mock_test_id INT UNSIGNED NOT NULL,
    total_questions SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    correct_count SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    score_percent DECIMAL(5,2) NOT NULL DEFAULT 0.00,
    time_taken_seconds INT UNSIGNED NULL,
    started_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    completed_at DATETIME NULL,
    KEY idx_mcq_mock_test_attempts_user (user_id, started_at),
    KEY idx_mcq_mock_test_attempts_mock_test (mock_test_id),
    CONSTRAINT fk_mcq_mta_user FOREIGN KEY (user_id) REFERENCES mcq_users (id) ON DELETE CASCADE,
    CONSTRAINT fk_mcq_mta_mock_test FOREIGN KEY (mock_test_id) REFERENCES mcq_mock_tests (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
