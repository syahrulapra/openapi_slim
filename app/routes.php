<?php

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function (App $app) {
    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write("Hello world!");
        return $response;
    });

    $app->get("/ticket", 'App\Http\Controllers\Tests\Ticket:index');
    $app->post("/ticket", 'App\Http\Controllers\Tests\Ticket:store');
    $app->put("/ticket/{id}", 'App\Http\Controllers\Tests\Ticket:update');
    $app->delete("/ticket/{id}", 'App\Http\Controllers\Tests\Ticket:delete');
};