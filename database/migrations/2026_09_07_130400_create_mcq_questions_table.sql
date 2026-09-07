CREATE TABLE IF NOT EXISTS mcq_questions (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    subject_id INT UNSIGNED NOT NULL,
    topic_id INT UNSIGNED NULL,
    question_text TEXT NOT NULL,
    explanation TEXT NULL,
    difficulty ENUM('easy', 'medium', 'hard') NOT NULL DEFAULT 'medium',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY idx_mcq_questions_subject_topic (subject_id, topic_id),
    KEY idx_mcq_questions_topic (topic_id),
    KEY idx_mcq_questions_difficulty (difficulty),
    CONSTRAINT fk_mcq_questions_subject FOREIGN KEY (subject_id) REFERENCES mcq_subjects (id) ON DELETE CASCADE,
    CONSTRAINT fk_mcq_questions_topic FOREIGN KEY (topic_id) REFERENCES mcq_topics (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
