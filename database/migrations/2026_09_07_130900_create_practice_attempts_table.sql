CREATE TABLE IF NOT EXISTS practice_attempts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    subject_id INT UNSIGNED NULL,
    topic_id INT UNSIGNED NULL,
    total_questions SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    correct_count SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    score_percent DECIMAL(5,2) NOT NULL DEFAULT 0.00,
    started_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    completed_at DATETIME NULL,
    KEY idx_practice_attempts_user (user_id, started_at),
    KEY idx_practice_attempts_subject (subject_id),
    KEY idx_practice_attempts_topic (topic_id),
    CONSTRAINT fk_practice_attempts_user FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    CONSTRAINT fk_practice_attempts_subject FOREIGN KEY (subject_id) REFERENCES subjects (id) ON DELETE SET NULL,
    CONSTRAINT fk_practice_attempts_topic FOREIGN KEY (topic_id) REFERENCES topics (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
