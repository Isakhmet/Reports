<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'oracle' => [
            'driver' => 'pgsql',
            'host' => env('ORACLE_DB_HOST', '127.0.0.1'),
            'port' => env('ORACLE_DB_PORT', '5432'),
            'database' => env('ORACLE_DB_DATABASE', 'score_service'),
            'username' => env('ORACLE_DB_USERNAME', 'crm_service'),
            'password' => env('ORACLE_DB_PASSWORD', 'crm_service'),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'crm' => [
            'driver' => 'mysql',
            'host' => env('CRM_DB_HOST', '127.0.0.1'),
            'port' => env('CRM_DB_PORT', '3306'),
            'database' => env('CRM_DB_DATABASE', 'crm_prodengi'),
            'username' => env('CRM_DB_USERNAME', 'crm_service'),
            'password' => env('CRM_DB_PASSWORD', 'crm_service'),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
                                                                      ]) : [],
        ],

        'sms' => [
            'driver' => 'pgsql',
            'host' => env('CM_DB_HOST', '127.0.0.1'),
            'port' => env('CM_DB_PORT', '5432'),
            'database' => env('CM_DB_DATABASE', 'campaign_manager'),
            'username' => env('CM_DB_USERNAME', 'postgres'),
            'password' => env('CM_DB_PASSWORD', 'postgres'),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'aster' => [
            'driver' => 'mysql',
            'host' => env('ASTER_DB_HOST', '10.8.0.190'),
            'port' => env('ASTER_DB_PORT', '3306'),
            'database' => env('ASTER_DB_DATABASE', 'asteriskcdrdb'),
            'username' => env('ASTER_DB_USERNAME', 'prodengi'),
            'password' => env('ASTER_DB_PASSWORD', 'aPozktp4r56FG'),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'monolit' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'monolit'),
            'username' => env('DB_USERNAME', 'monolit'),
            'password' => env('DB_PASSWORD', 'monolit'),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'landings' => [
            'driver' => 'pgsql',
            'host' => env('LND_DB_HOST', '10.10.11.24'),
            'port' => env('LND_DB_PORT', '9032'),
            'database' => env('LND_DB_DATABASE', 'landings'),
            'username' => env('LND_DB_USERNAME', 'reporting'),
            'password' => env('LND_DB_PASSWORD', 'm{1!cp$t6[-]]'),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'score_gate' => [
            'driver' => 'pgsql',
            'host' => env('SG_DB_HOST', '10.10.11.11'),
            'port' => env('SG_DB_PORT', '5432'),
            'database' => env('SG_DB_DATABASE', 'score_gate'),
            'username' => env('SG_DB_USERNAME', 'report'),
            'password' => env('SG_DB_PASSWORD', 'fQ5dnAWK0iyu'),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'lead_gate' => [
            'driver' => 'pgsql',
            'host' => env('LG_DB_HOST', '10.10.11.11'),
            'port' => env('LG_DB_PORT', '5432'),
            'database' => env('LG_DB_DATABASE', 'lead_gate'),
            'username' => env('LG_DB_USERNAME', 'report'),
            'password' => env('LG_DB_PASSWORD', 'fQ5dnAWK0iyu'),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                                                                          PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
                                                                      ]) : [],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'predis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'predis'),
            'prefix' => Str::slug(env('APP_NAME', 'laravel'), '_').'_database_',
        ],

        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_DB', 0),
        ],

        'cache' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_CACHE_DB', 1),
        ],

    ],

];
