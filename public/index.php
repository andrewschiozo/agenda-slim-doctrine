<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->addRoutingMiddleware();

// params: displayErrorDetails, logErrors, logErrorDetails
$displayErrorDetails = ($_ENV['APP_ENV'] ?? 'prod') === 'desenv';
$errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, true, true);

$app->get('/agenda/index', function ($request, $response, $args) {
    $response->getBody()->write("teste");
    return $response;
});

$app->run();