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

        $content = $this->service->listar($pagina);

        return $this->response($response, 200, $content);
    }

    /**
     * Busca um contato por id.
     */
    public function buscar(Request $request, Response $response, array $args): Response
    {
        $id = (int) $args['id'];
        $contato = $this->service->buscarPorId($id);

        if (!$contato) {
            $this->response($response, 404);
        }

        return $this->response($response, 200, $contato);
    }

    public function salvar(Request $request, Response $response, array $args): Response
    {
        try {
            $dados = $request->getParsedBody() ?? [];
            $dto = ContatoDTO::fromArray($dados);

            $dto->id = isset($args['id']) ? (int) $args['id'] : $dto->id;

            $content = $this->service->salvar($dto);

            return $this->response(
                $response,
                $dto->id ? 204 : 201,
                $content
            );
        } catch (InvalidArgumentException $e) {
            return $this->response(
                $response,
                400,
                ['erro' => $e->getMessage()]
            );
        }
    }

    public function excluir(Request $request, Response $response, array $args): Response
    {
        $id = (int) $args['id'];
        $this->service->excluir($id);
        return $this->response($response, 204, null);
    }

    private function response(Response $response, int $httpCode = 200, object|array|null $content = null): Response
    {
        if ($content) {
            $response->getBody()->write(json_encode($content));
        }

        return $response->withHeader('Content-Type', 'application/json')->withStatus($httpCode);
    }
}