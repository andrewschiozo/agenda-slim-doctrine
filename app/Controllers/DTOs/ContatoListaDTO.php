<?php

namespace App\Controllers\DTOs;

use TypeError;

/**
 * Classe com a lista de contatos com paginação para o frontend
 */
class ContatoListaDTO
{
    public function __construct(
        /** @var array<ContatoDTO> */
        public array $dados,
        public ListaMetadadosDTO $metadados
    ) {
        foreach ($dados as $contato) {
            if (!($contato instanceof ContatoDTO)) {
                throw new TypeError('O contato em ' . self::class . ' deve ser do tipo ' . ContatoDTO::class);
            }
        }
    }
}