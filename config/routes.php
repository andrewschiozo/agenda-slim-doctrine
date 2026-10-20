<?php

use Slim\App;

/**
 * Define todas as rotas da aplicação.
 * 
 * @param App $app A instância da aplicação Slim
 * @param mixed $webController Controller do frontend
 * @param mixed $apiController Controller da api
 */
return function (App $app, $webController, $apiController) {

    // rotas do front
    $app->get('/agenda/index', function ($request, $response) use ($webController) {
        return $webController->index($request, $response);
    });
    $app->get('/agenda/create', function ($request, $response) use ($webController) {
        return $webController->form($request, $response);
    });
    $app->get('/agenda/edit/{id}', function ($request, $response) use ($webController) {
        return $webController->form($request, $response);
    });

    // rotas de api
    $app->get('/api/contatos', function ($request, $response) use ($apiController) {
        return $apiController->listar($request, $response);
    });
    $app->get('/api/contatos/{id}', function ($request, $response, $args) use ($apiController) {
        return $apiController->buscar($request, $response, $args);
    });
    $app->post('/api/contatos', function ($request, $response, $args) use ($apiController) {
        return $apiController->salvar($request, $response, $args);
    });
    $app->put('/api/contatos/{id}', function ($request, $response, $args) use ($apiController) {
        return $apiController->salvar($request, $response, $args);
    });
    $app->delete('/api/contatos/{id}', function ($request, $response, $args) use ($apiController) {
        return $apiController->excluir($request, $response, $args);
    });

};