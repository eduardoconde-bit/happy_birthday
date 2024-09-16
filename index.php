<?php

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;

require __DIR__ . '/vendor/autoload.php';

// Crie o contêiner primeiro

$container = new Container();
AppFactory::setContainer($container);

// Depois crie o App
$app = AppFactory::create();

// Adicione Middleware de Rotas
$app->addRoutingMiddleware();

// Defina o controlador no contêiner
$container->set('ItemController', function() {
    return new \App\Controller\ItemController();
});

// Middleware de Erros
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// Primeira Rota
$app->get('/api', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Bem Vindo a API!");
    return $response;
});

// Rota de Grupo
$app->group("/api/items", function (\Slim\Routing\RouteCollectorProxy $group) {
    $group->get("", \App\Controller\ItemController::class . ":index");
    $group->post("", \App\Controller\ItemController::class . ":create");
    $group->put("/{id}", \App\Controller\ItemController::class . ":update");
    $group->delete("/{id}", \App\Controller\ItemController::class . ":delete");
});



// Execute o App
$app->run();
