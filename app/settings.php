<?php
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
  $containerBuilder->addDefinitions([
    'settings' => [
      'displayErrorDetails' => true,
      'db' => [
        'driver' => env('DB_DRIVER'),
        'host' => env('DB_HOST'),
        'database' => env('DB_NAME'),
        'username' => env('DB_USER'),
        'password' => env('DB_PASS'),
        'charset' => env('DB_CHARSET'),
        'collation' => env('DB_COLLATION'),
        'prefix' => env('DB_PREFIX'),
      ],
      'jwt_authentication' => [
        'secret' => env('JWT_SECRET'),
        'algorithm' => 'HS256',
        'secure' => false
      ],
    ]
  ]);
};