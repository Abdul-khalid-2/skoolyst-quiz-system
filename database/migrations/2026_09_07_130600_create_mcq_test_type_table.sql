-- Pivot: a question can belong to more than one test type's question bank (e.g. reused across MDCAT and School Exams)
CREATE TABLE IF NOT EXISTS mcq_test_type (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    mcq_id INT UNSIGNED NOT NULL,
    test_type_id INT UNSIGNED NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_mcq_test_type (mcq_id, test_type_id),
    KEY idx_mcq_test_type_test_type (test_type_id),
    CONSTRAINT fk_mcq_tt_mcq FOREIGN KEY (mcq_id) REFERENCES mcq_questions (id) ON DELETE CASCADE,
    CONSTRAINT fk_mcq_tt_test_type FOREIGN KEY (test_type_id) REFERENCES mcq_test_types (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
