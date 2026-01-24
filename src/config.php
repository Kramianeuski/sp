<?php

declare(strict_types=1);

return [
    'db' => [
        'dsn' => getenv('DB_DSN') ?: 'mysql:host=127.0.0.1;dbname=system_power;charset=utf8mb4',
        'user' => getenv('DB_USER') ?: 'system_power',
        'pass' => getenv('DB_PASS') ?: 'SpPwJs)9kskdH1kalk)9ss#1',
    ],
    'base_url' => getenv('BASE_URL') ?: '',
    'theme' => getenv('THEME') ?: 'default',
    'admin' => [
        'session_key' => 'sp_admin',
    ],
    'cache' => [
        'enabled' => getenv('CACHE_ENABLED') ? (bool) getenv('CACHE_ENABLED') : false,
        'path' => __DIR__ . '/../storage/cache',
        'ttl' => 300,
    ],
];
