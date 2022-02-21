<?php
// EXECUTA AS MIGRATIONS DE ACORDO AO AMBIENTE

return
[
    'paths' => [
        'migrations' => [
            dirname(__DIR__, 2).'/db/migrations/logs/tabelas',
            dirname(__DIR__, 2).'/db/migrations/logs/functions',
            dirname(__DIR__, 2).'/db/migrations/logs/procedures',
            dirname(__DIR__, 2).'/db/migrations/logs/triggers',
            dirname(__DIR__, 2).'/db/migrations/logs/updates',
            //dirname(__DIR__, 2).'/db/migrations/logs/views',
        ],
        'seeds'      => [
            dirname(__DIR__, 2).'/db/seeds/log'
        ]
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment'     => 'database',
        'database'              => [
            'adapter' => getenv('PROD_BASE_DB_ADAPTER'),
            'host'    => getenv('PROD_BASE_DB_HOST'),
            'name'    => getenv('PROD_BASE_DB_NAME'),
            'user'    => getenv('PROD_BASE_DB_USER'),
            'pass'    => getenv('PROD_BASE_DB_PASS'),
            'port'    => getenv('PROD_BASE_DB_PORT'),
            'charset' => getenv('PROD_BASE_DB_CHAR'),
        ]
    ],
    'version_order' => 'creation'
];
