<?php
// retorna as conexões

return [
    // DATABASE: SISTEMA
    'system' => [
        'type'      => getenv('DEV_BASE_DB_ADAPTER'),
        'host'      => getenv('DEV_BASE_DB_HOST'),
        'user'      => getenv('DEV_BASE_DB_USER'),
        'pass'      => getenv('DEV_BASE_DB_PASS'),
        'port'      => getenv('DEV_BASE_DB_PORT'),
        'name'      => getenv('DEV_BASE_DB_NAME'),
        'charset'   => getenv('DEV_BASE_DB_CHAR'),
    ],
    // DATABASE: EAD
    'log'     => [
        'type'      => getenv('DB_LOG_ADAPTER'),
        'host'      => getenv('DB_LOG_HOST'),
        'user'      => getenv('DB_LOG_USER'),
        'pass'      => getenv('DB_LOG_PASS'),
        'port'      => getenv('DB_LOG_PORT'),
        'name'      => getenv('DB_LOG_NAME'),
        'charset'   => getenv('DB_LOG_CHAR')
    ]
];
