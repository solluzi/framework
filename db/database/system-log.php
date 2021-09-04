<?php
// EXECUTA AS MIGRATIONS DE ACORDO AO AMBIENTE

return
[
    'paths' => [
        'migrations' => [
            dirname(__DIR__, 2).'/db/migrations/system-logs/tabelas',
            dirname(__DIR__, 2).'/db/migrations/system-logs/functions',
            dirname(__DIR__, 2).'/db/migrations/system-logs/procedures',
            dirname(__DIR__, 2).'/db/migrations/system-logs/triggers',
            dirname(__DIR__, 2).'/db/migrations/system-logs/updates',
            //dirname(__DIR__, 2).'/db/migrations/logs/views',
        ],
        'seeds'      => [
            dirname(__DIR__, 2).'/db/seeds/log'
        ]
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment'     => 'dev',
        'prd'              => [
            'adapter' => getenv('PROD_BASE_DB_ADAPTER'),
            'host'    => getenv('PROD_BASE_DB_HOST'),
            'name'    => getenv('PROD_BASE_DB_NAME'),
            'user'    => getenv('PROD_BASE_DB_USER'),
            'pass'    => getenv('PROD_BASE_DB_PASS'),
            'port'    => getenv('PROD_BASE_DB_PORT'),
            'charset' => getenv('PROD_BASE_DB_CHAR'),
        ],
        'dev' => [
            'adapter' => getenv('LOG_DB_TYPE'),
            'host'    => getenv('LOG_DB_HOST'),
            'name'    => getenv('LOG_DB_NAME'),
            'user'    => getenv('LOG_DB_USER'),
            'pass'    => getenv('LOG_DB_PASS'),
            'port'    => getenv('LOG_DB_PORT'),
            'charset' => getenv('LOG_DB_CHAR'),
        ],
        'testing' => [
            'adapter' => getenv('TESTING_SYSTEM_DB_TYPE'),
            'host'    => getenv('TESTING_SYSTEM_DB_HOST'),
            'name'    => getenv('TESTING_SYSTEM_DB_NAME'),
            'user'    => getenv('TESTING_SYSTEM_DB_USER'),
            'pass'    => getenv('TESTING_SYSTEM_DB_PASS'),
            'port'    => getenv('TESTING_SYSTEM_DB_PORT'),
            'charset' => getenv('TESTING_SYSTEM_DB_CHAR'),
        ]
    ],
    'version_order' => 'creation'
];
