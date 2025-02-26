<?php

use DI\Container;
use Illuminate\Database\Capsule\Manager as Capsule;

return function (Container $container) {
  $capsuleSettings = $container->get('settings')['db'];

  $capsule = new Capsule;
  $capsule->addConnection($capsuleSettings);
  $capsule->setAsGlobal();
  $capsule->bootEloquent();

  $container->set('db', $capsule);
};
