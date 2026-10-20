<?php

namespace App\Controllers\DTOs;

use InvalidArgumentException;

/**
 * DTO para input e listagem do frontend
 */
class ContatoDTO
{
    public ?int $id = null;
    public string $nome;
    public ?string $dataNascimento = null;
    public ?string $logradouro = null;
    public ?string $numero = null;
    public ?string $bairro = null;
    public ?string $cidade = null;
    public ?string $uf = null;
    public ?string $cep = null;

    public static function fromArray(array $dados): self
    {
        $dto = new self();
        $dto->id = $dados['id'] ?? null;
        $dto->nome = $dados['nome'] ?? throw new InvalidArgumentException("O campo nome é obrigatório.");
        $dto->dataNascimento = $dados['data_nascimento'] ?? null;
        $dto->logradouro = $dados['logradouro'] ?? null;
        $dto->numero = $dados['numero'] ?? null;
        $dto->bairro = $dados['bairro'] ?? null;
        $dto->cidade = $dados['cidade'] ?? null;
        $dto->uf = $dados['uf'] ?? null;
        $dto->cep = $dados['cep'] ?? null;
        
        return $dto;
    }
}