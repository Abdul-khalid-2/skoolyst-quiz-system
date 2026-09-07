-- Pivot: ordered set of MCQs that make up a mock test
CREATE TABLE IF NOT EXISTS mock_test_mcqs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    mock_test_id INT UNSIGNED NOT NULL,
    mcq_id INT UNSIGNED NOT NULL,
    sort_order SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    UNIQUE KEY uq_mock_test_mcqs (mock_test_id, mcq_id),
    KEY idx_mock_test_mcqs_mcq (mcq_id),
    KEY idx_mock_test_mcqs_order (mock_test_id, sort_order),
    CONSTRAINT fk_mtm_mock_test FOREIGN KEY (mock_test_id) REFERENCES mock_tests (id) ON DELETE CASCADE,
    CONSTRAINT fk_mtm_mcq FOREIGN KEY (mcq_id) REFERENCES mcqs (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
