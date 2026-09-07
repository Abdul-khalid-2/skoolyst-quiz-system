CREATE TABLE IF NOT EXISTS mcq_options (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    mcq_id INT UNSIGNED NOT NULL,
    label CHAR(1) NOT NULL,
    option_text VARCHAR(500) NOT NULL,
    is_correct TINYINT(1) NOT NULL DEFAULT 0,
    sort_order TINYINT UNSIGNED NOT NULL DEFAULT 0,
    UNIQUE KEY uq_mcq_options_mcq_label (mcq_id, label),
    KEY idx_mcq_options_mcq_correct (mcq_id, is_correct),
    CONSTRAINT fk_mcq_options_mcq FOREIGN KEY (mcq_id) REFERENCES mcq_questions (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
