<?php
return [
    'base_url' => rtrim($_ENV['ADS_API_BASE'] ?? '', '/'),
    'api_key' => $_ENV['ADS_API_KEY'] ?? '',
    'cache_ttl' => (int)($_ENV['ADS_CACHE_TTL'] ?? 30),
    'placements' => [
        'home_top' => $_ENV['ADS_PLACEMENT_HOME_TOP'] ?? null,
        'subject_top' => $_ENV['ADS_PLACEMENT_SUBJECT_TOP'] ?? null,
        'test_type_top' => $_ENV['ADS_PLACEMENT_TEST_TYPE_TOP'] ?? null,
        'mock_test_top' => $_ENV['ADS_PLACEMENT_MOCK_TEST_TOP'] ?? null,
    ],
];
