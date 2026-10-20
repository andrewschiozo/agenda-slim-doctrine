<?php

namespace App\Controllers\DTOs;

/**
 * Classe genérica de metadados para as listas do frontend
 */
class ListaMetadadosDTO
{
    public function __construct(
        public int $totalRegistros,
        public int $paginaAtual,
        public int $registrosPorPagina,
        public int $totalPaginas
    ) {}
}
