CREATE TABLE IF NOT EXISTS mcq_practice_attempt_answers (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    practice_attempt_id INT UNSIGNED NOT NULL,
    mcq_id INT UNSIGNED NOT NULL,
    selected_option_id INT UNSIGNED NULL,
    is_correct TINYINT(1) NOT NULL DEFAULT 0,
    answered_at DATETIME NULL,
    UNIQUE KEY uq_mcq_practice_attempt_answers (practice_attempt_id, mcq_id),
    KEY idx_mcq_practice_attempt_answers_mcq (mcq_id),
    KEY idx_mcq_practice_attempt_answers_option (selected_option_id),
    CONSTRAINT fk_mcq_paa_attempt FOREIGN KEY (practice_attempt_id) REFERENCES mcq_practice_attempts (id) ON DELETE CASCADE,
    CONSTRAINT fk_mcq_paa_mcq FOREIGN KEY (mcq_id) REFERENCES mcq_questions (id) ON DELETE CASCADE,
    CONSTRAINT fk_mcq_paa_option FOREIGN KEY (selected_option_id) REFERENCES mcq_options (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
