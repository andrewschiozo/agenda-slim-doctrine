<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;
use Slim\Csrf\Guard;

/**
 * Controller responsável pela exibição das views
 */
class AgendaController
{
    public function __construct(
        private PhpRenderer $renderer,
        private Guard $csrf
    ) { }

    public function index(Request $request, Response $response): Response
    {
        return $this->renderer->render($response, 'index.php', $this->getCsrfTokens($request));
    }

    public function form(Request $request, Response $response): Response
    {
        return $this->renderer->render($response, 'form.php', $this->getCsrfTokens($request));
    }

    /**
     * Extrai os tokens CSRF para os enviar para as views
     */
    private function getCsrfTokens(Request $request): array
    {
        return [
            'csrfNameKey' => $this->csrf->getTokenNameKey(),
            'csrfValueKey' => $this->csrf->getTokenValueKey(),
            'csrfName' => $request->getAttribute($this->csrf->getTokenNameKey()),
            'csrfValue' => $request->getAttribute($this->csrf->getTokenValueKey())
        ];
    }
}