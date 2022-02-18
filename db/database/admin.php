<?php
// EXECUTA AS MIGRATIONS DE ACORDO AO AMBIENTE

return
[
    'paths' => [
        'migrations' => [
            dirname(__DIR__, 2).'/db/migrations/system-admin/tabelas',
            dirname(__DIR__, 2).'/db/migrations/system-admin/functions',
            dirname(__DIR__, 2).'/db/migrations/system-admin/procedures',
            dirname(__DIR__, 2).'/db/migrations/system-admin/triggers',
            dirname(__DIR__, 2).'/db/migrations/system-admin/updates',
            dirname(__DIR__, 2).'/db/migrations/system-admin/views',
            dirname(__DIR__, 2).'/db/migrations/system-admin/server',
        ],
        'seeds'      => [
            dirname(__DIR__, 2).'/db/seeds/admin'
        ]
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment'     => 'dev',
        'database'              => [
            'adapter' => getenv('PROD_BASE_DB_ADAPTER'),
            'host'    => getenv('PROD_BASE_DB_HOST'),
            'name'    => getenv('PROD_BASE_DB_NAME'),
            'user'    => getenv('PROD_BASE_DB_USER'),
            'pass'    => getenv('PROD_BASE_DB_PASS'),
            'port'    => getenv('PROD_BASE_DB_PORT'),
            'charset' => getenv('PROD_BASE_DB_CHAR'),
        ],
        'dev' => [
            'adapter' => getenv('PERMISSION_DB_TYPE'),
            'host'    => getenv('PERMISSION_DB_HOST'),
            'name'    => getenv('PERMISSION_DB_NAME'),
            'user'    => getenv('PERMISSION_DB_USER'),
            'pass'    => getenv('PERMISSION_DB_PASS'),
            'port'    => getenv('PERMISSION_DB_PORT'),
            'charset' => getenv('PERMISSION_DB_CHAR'),
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
