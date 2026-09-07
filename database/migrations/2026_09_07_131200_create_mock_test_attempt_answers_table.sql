CREATE TABLE IF NOT EXISTS mock_test_attempt_answers (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    mock_test_attempt_id INT UNSIGNED NOT NULL,
    mcq_id INT UNSIGNED NOT NULL,
    selected_option_id INT UNSIGNED NULL,
    is_correct TINYINT(1) NOT NULL DEFAULT 0,
    is_marked_for_review TINYINT(1) NOT NULL DEFAULT 0,
    answered_at DATETIME NULL,
    UNIQUE KEY uq_mock_test_attempt_answers (mock_test_attempt_id, mcq_id),
    KEY idx_mock_test_attempt_answers_mcq (mcq_id),
    KEY idx_mock_test_attempt_answers_option (selected_option_id),
    CONSTRAINT fk_mtaa_attempt FOREIGN KEY (mock_test_attempt_id) REFERENCES mock_test_attempts (id) ON DELETE CASCADE,
    CONSTRAINT fk_mtaa_mcq FOREIGN KEY (mcq_id) REFERENCES mcqs (id) ON DELETE CASCADE,
    CONSTRAINT fk_mtaa_option FOREIGN KEY (selected_option_id) REFERENCES mcq_options (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
