<?php

// csrf
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\AgendaController;
use App\Controllers\AgendaAPIController;
use App\Repositories\ContatoRepository;
use App\Services\ContatoService;
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;
use Slim\Csrf\Guard;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

$entityManager = require_once __DIR__ . '/../config/doctrine.php';

$app = AppFactory::create();

// slim middlewares
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();

// middleware CSRF
$responseFactory = $app->getResponseFactory();
$csrf = new Guard($responseFactory);

$displayErrorDetails = ($_ENV['APP_ENV'] ?? 'prod') === 'desenv';
$app->addErrorMiddleware($displayErrorDetails, true, true);

// injeção de dependências
$repository = new ContatoRepository($entityManager);
$service = new ContatoService($repository);
$apiController = new AgendaAPIController($service);

// PHP Renderer para o slim view
$renderer = new PhpRenderer(__DIR__ . '/../app/Views');
$renderer->setLayout('layout.php');
$webController = new AgendaController($renderer, $csrf);

// rotas
$routes = require __DIR__ . '/../config/routes.php';
$routes($app, $webController, $apiController);

$app->run();