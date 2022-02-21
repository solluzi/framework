<?php
// EXECUTA AS MIGRATIONS DE ACORDO AO AMBIENTE

return
[
    'paths' => [
        'migrations' => [
            dirname(__DIR__, 2).'/db/migrations/admin/tabelas',
            dirname(__DIR__, 2).'/db/migrations/admin/functions',
            dirname(__DIR__, 2).'/db/migrations/admin/procedures',
            dirname(__DIR__, 2).'/db/migrations/admin/triggers',
            dirname(__DIR__, 2).'/db/migrations/admin/updates',
            dirname(__DIR__, 2).'/db/migrations/admin/views',
            dirname(__DIR__, 2).'/db/migrations/admin/server',
        ],
        'seeds'      => [
            dirname(__DIR__, 2).'/db/seeds/admin'
        ]
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment'     => 'database',
        'database'              => [
            'adapter' => getenv('PERMISSION_DB_TYPE'),
            'host'    => getenv('PERMISSION_DB_HOST'),
            'name'    => getenv('PERMISSION_DB_NAME'),
            'user'    => getenv('PERMISSION_DB_USER'),
            'pass'    => getenv('PERMISSION_DB_PASS'),
            'port'    => getenv('PERMISSION_DB_PORT'),
            'charset' => getenv('PERMISSION_DB_CHAR'),
        ]
    ],
    'version_order' => 'creation'
];
