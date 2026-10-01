<?php
return [
    'base_url' => rtrim($_ENV['SKOOLYST_AUTH_BASE'] ?? '', '/'),
    'client_id' => $_ENV['SKOOLYST_AUTH_CLIENT_ID'] ?? '',
    'client_secret' => $_ENV['SKOOLYST_AUTH_CLIENT_SECRET'] ?? '',
    'redirect_uri' => $_ENV['SKOOLYST_AUTH_REDIRECT_URI'] ?? '',
];
