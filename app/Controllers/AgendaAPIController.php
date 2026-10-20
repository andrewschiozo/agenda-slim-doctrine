<?php

namespace App\Controllers;

use App\Controllers\DTOs\ContatoDTO;
use App\Services\ContatoService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use InvalidArgumentException;

/**
 * Controller responsável pelos endpoints da API
 */
class AgendaAPIController
{
    public function __construct(
        private ContatoService $service
    ) { }

    public function listar(Request $request, Response $response): Response
    {
        $params = $request->getQueryParams();
        $pagina = isset($params['pagina']) ? (int) $params['pagina'] : 1;

        $resultado = $this->service->listar($pagina);

        $response->getBody()->write(json_encode($resultado));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function salvar(Request $request, Response $response, array $args): Response
    {
        try {
            $dados = $request->getParsedBody() ?? [];
            $dto = ContatoDTO::fromArray($dados);

            $dto->id = isset($args['id']) ? (int) $args['id'] : $dto->id;
            $this->service->salvar($dto);

            return $response->withHeader('Content-Type', 'application/json')->withStatus($dto->id ? 200 : 201);
            
        } catch (InvalidArgumentException $e) {
            $response->getBody()->write(json_encode([
                'erro' => $e->getMessage()
            ]));

            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
    }

    public function excluir(Request $request, Response $response, array $args): Response
    {
        $id = (int) $args['id'];
        $this->service->excluir($id);

        return $response->withHeader('Content-Type', 'application/json')->withStatus(204);
    }
}