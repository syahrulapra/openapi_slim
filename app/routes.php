<?php

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Tuupola\Middleware\JwtAuthentication;

return function (App $app) {
    $container = $app->getContainer();

    $app->add(function (Request $request, RequestHandlerInterface $handler) use ($app): Response {
        ($request->getMethod() === 'OPTIONS') ? 
            $response = $app->getResponseFactory()->createResponse() : 
            $response = $handler->handle($request);


        $response = $response
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', '*')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS')
            ->withHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->withHeader('Pragma', 'no-cache');

        (ob_get_contents()) ?: ob_clean();

        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write("Hello world!");
        return $response;
    });

    $app->get('/docs', function (Request $request, Response $response) {
        $yamlFile = __DIR__ . '/../openapi.yaml';
        $response->getBody()->write(file_get_contents($yamlFile));
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->group('/api', function ($app) {
        $app->get("/tickets", 'App\Http\Controllers\TicketController:index');
        $app->post("/tickets", 'App\Http\Controllers\TicketController:store');
        $app->put("/tickets/{id}", 'App\Http\Controllers\TicketController:update');
        $app->delete("/tickets/{id}", 'App\Http\Controllers\TicketController:delete');
    })->addMiddleware($container->get(JwtAuthentication::class));

    $app->post('/login', 'App\Http\Controllers\Auth\AuthController:login');
};