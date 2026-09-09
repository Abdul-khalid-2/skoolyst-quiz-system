ALTER TABLE mcq_users
    ADD COLUMN role VARCHAR(20) NOT NULL DEFAULT 'user' AFTER password;

UPDATE mcq_users SET role = 'admin' WHERE email = 'skoolyst@gmail.com';
