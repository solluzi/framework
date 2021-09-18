<?php
/*
|--------------------------------------------------------------------------
|                            databases credentials
|--------------------------------------------------------------------------
|
| here we format all credentials to access differents databases
|
*/


return [
    /*
    |--------------------------------------------------------------------------
    |                          system database
    |--------------------------------------------------------------------------
    |
    | 
    |
    */
    
    'system' => [
        'type'      => getenv('PERMISSION_DB_TYPE'),
        'host'      => getenv('PERMISSION_DB_HOST'),
        'user'      => getenv('PERMISSION_DB_USER'),
        'pass'      => getenv('PERMISSION_DB_PASS'),
        'port'      => getenv('PERMISSION_DB_PORT'),
        'name'      => getenv('PERMISSION_DB_NAME'),
        'charset'   => getenv('PERMISSION_DB_CHAR'),
    ],
    
    /*
    |--------------------------------------------------------------------------
    |                         system log database
    |--------------------------------------------------------------------------
    |
    | 
    |
    */
    
    'log'     => [
        'type'      => getenv('LOG_DB_TYPE'),
        'host'      => getenv('LOG_DB_HOST'),
        'user'      => getenv('LOG_DB_USER'),
        'pass'      => getenv('LOG_DB_PASS'),
        'port'      => getenv('LOG_DB_PORT'),
        'name'      => getenv('LOG_DB_NAME'),
        'charset'   => getenv('LOG_DB_CHAR')
    ]
];
