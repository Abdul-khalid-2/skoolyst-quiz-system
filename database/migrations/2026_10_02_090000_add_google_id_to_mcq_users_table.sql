ALTER TABLE mcq_users
    ADD COLUMN google_id VARCHAR(64) NULL UNIQUE AFTER skoolyst_id;
