<?php
return [
    'base_url' => rtrim($_ENV['EMAIL_API_BASE'] ?? '', '/'),
    'api_key' => $_ENV['EMAIL_API_KEY'] ?? '',
    'source_app' => $_ENV['EMAIL_SOURCE_APP'] ?? 'skoolyst-mcqs',
    'admin_email' => $_ENV['ADMIN_NOTIFICATION_EMAIL'] ?? '',
];
