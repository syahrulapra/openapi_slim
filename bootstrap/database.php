<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$capsule = new Capsule();
$capsule->addConnection([
    'driver' => env('DB_DRIVER'),
    'host' => env('DB_HOST'),
    'database' => env('DB_NAME'),
    'username' => env('DB_USER'),
    'password' => env('DB_PASS'),
    'charset' => env('DB_CHARSET'),
    'collation' => env('DB_COLLATION'),
    'prefix' => env('DB_PREFIX'),
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();