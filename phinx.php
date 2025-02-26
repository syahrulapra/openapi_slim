<?php
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

if (!checkDB()) {
    die("Failed to ensure database exists. Please check your configuration.\n");
}

return
    [
        'paths' => [
            'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
            'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
        ],
        'environments' => [
            'default_migration_table' => 'phinxlog',
            'default_environment' => 'development',
            'production' => [
                'adapter' => 'mysql',
                'host' => env('DB_HOST'),
                'name' => env('DB_NAME'),
                'user' => env('DB_USER'),
                'pass' => env('DB_PASS'),
                'port' => '3306',
                'charset' => 'utf8',
            ],
            'development' => [
                'adapter' => 'mysql',
                'host' => env('DB_HOST'),
                'name' => env('DB_NAME'),
                'user' => env('DB_USER'),
                'pass' => env('DB_PASS'),
                'port' => '3306',
                'charset' => 'utf8',
            ],
            'testing' => [
                'adapter' => 'mysql',
                'host' => env('DB_HOST'),
                'name' => env('DB_NAME'),
                'user' => env('DB_USER'),
                'pass' => env('DB_PASS'),
                'port' => '3306',
                'charset' => 'utf8',
            ]
        ],
        'version_order' => 'creation'
    ];
