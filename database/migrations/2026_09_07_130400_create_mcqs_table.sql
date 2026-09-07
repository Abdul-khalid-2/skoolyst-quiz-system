CREATE TABLE IF NOT EXISTS mcqs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    subject_id INT UNSIGNED NOT NULL,
    topic_id INT UNSIGNED NULL,
    question_text TEXT NOT NULL,
    explanation TEXT NULL,
    difficulty ENUM('easy', 'medium', 'hard') NOT NULL DEFAULT 'medium',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY idx_mcqs_subject_topic (subject_id, topic_id),
    KEY idx_mcqs_topic (topic_id),
    KEY idx_mcqs_difficulty (difficulty),
    CONSTRAINT fk_mcqs_subject FOREIGN KEY (subject_id) REFERENCES subjects (id) ON DELETE CASCADE,
    CONSTRAINT fk_mcqs_topic FOREIGN KEY (topic_id) REFERENCES topics (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
