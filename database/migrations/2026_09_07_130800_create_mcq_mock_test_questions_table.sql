-- Pivot: ordered set of questions that make up a mock test
CREATE TABLE IF NOT EXISTS mcq_mock_test_questions (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    mock_test_id INT UNSIGNED NOT NULL,
    mcq_id INT UNSIGNED NOT NULL,
    sort_order SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    UNIQUE KEY uq_mcq_mock_test_questions (mock_test_id, mcq_id),
    KEY idx_mcq_mock_test_questions_mcq (mcq_id),
    KEY idx_mcq_mock_test_questions_order (mock_test_id, sort_order),
    CONSTRAINT fk_mcq_mtq_mock_test FOREIGN KEY (mock_test_id) REFERENCES mcq_mock_tests (id) ON DELETE CASCADE,
    CONSTRAINT fk_mcq_mtq_mcq FOREIGN KEY (mcq_id) REFERENCES mcq_questions (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
