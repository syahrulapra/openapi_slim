<?php
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$containerBuilder = new ContainerBuilder();

$settings = require __DIR__ . '/../app/settings.php';
$settings($containerBuilder);

$container = $containerBuilder->build();

$dependencies = require __DIR__ . '/../app/dependencies.php';
$dependencies($container);

AppFactory::setContainer($container);
$app = AppFactory::create();

$app->addRoutingMiddleware();

$routes = require __DIR__ . '/../app/routes.php';
$routes($app);

$errorSetting = $app->getContainer()->get('settings')['displayErrorDetails'];
$app->addErrorMiddleware($errorSetting, true, true);

$app->run();