<?php

use DI\Container;
use Tuupola\Middleware\JwtAuthentication;
use Illuminate\Database\Capsule\Manager as Capsule;

return function (Container $container) {
  $capsuleSettings = $container->get('settings')['db'];
  $jwtSettings = $container->get('settings')['jwt_authentication'];

  $capsule = new Capsule;
  $capsule->addConnection($capsuleSettings);
  $capsule->setAsGlobal();
  $capsule->bootEloquent();

  $container->set('db', $capsule);

  $container->set(JwtAuthentication::class, function () use ($jwtSettings) {
    return new JwtAuthentication($jwtSettings);
  });
};
