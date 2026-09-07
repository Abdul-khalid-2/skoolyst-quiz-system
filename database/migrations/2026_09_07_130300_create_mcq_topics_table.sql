CREATE TABLE IF NOT EXISTS mcq_topics (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    subject_id INT UNSIGNED NOT NULL,
    name VARCHAR(160) NOT NULL,
    slug VARCHAR(160) NOT NULL,
    description TEXT NULL,
    icon VARCHAR(60) NULL,
    difficulty ENUM('easy', 'medium', 'hard') NOT NULL DEFAULT 'medium',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_mcq_topics_subject_slug (subject_id, slug),
    KEY idx_mcq_topics_difficulty (difficulty),
    CONSTRAINT fk_mcq_topics_subject FOREIGN KEY (subject_id) REFERENCES mcq_subjects (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
