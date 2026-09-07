-- Pivot: which subjects belong to which test types (e.g. Biology is part of MDCAT, School Exams, GK)
CREATE TABLE IF NOT EXISTS subject_test_type (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    subject_id INT UNSIGNED NOT NULL,
    test_type_id INT UNSIGNED NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_subject_test_type (subject_id, test_type_id),
    KEY idx_subject_test_type_test_type (test_type_id),
    CONSTRAINT fk_stt_subject FOREIGN KEY (subject_id) REFERENCES subjects (id) ON DELETE CASCADE,
    CONSTRAINT fk_stt_test_type FOREIGN KEY (test_type_id) REFERENCES test_types (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
