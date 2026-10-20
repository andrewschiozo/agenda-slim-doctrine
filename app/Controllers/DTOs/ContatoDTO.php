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
    public string $dataNascimento;
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

        $nome = $dados['nome'] ?? throw new InvalidArgumentException("O campo nome é obrigatório.");
        $dto->nome = self::sanitizeAndValidateString($nome, 255, 'nome');

        $dataNascimento = $dados['data_nascimento'] ?? throw new InvalidArgumentException("O campo data de nascimento é obrigatório.");
        $dto->dataNascimento = self::sanitizeAndValidateString($dataNascimento, 10, 'data de nascimento');

        $dto->logradouro = isset($dados['logradouro']) ? self::sanitizeAndValidateString($dados['logradouro'], 255, 'logradouro') : null;

        $dto->numero = $dados['numero'] ?? null;
        $dto->bairro = $dados['bairro'] ?? null;
        $dto->cidade = $dados['cidade'] ?? null;
        $dto->uf = $dados['uf'] ?? null;
        $dto->cep = $dados['cep'] ?? null;
        
        return $dto;
    }

    /**
     * Limpa tags HTML e valida o comprimento máximo da string.
     *
     * @param string $value O valor a ser validado
     * @param int $maxLength O tamanho máximo permitido
     * @param string $fieldName O nome do campo para exibição na mensagem de erro
     * @return string
     * @throws InvalidArgumentException
     */
    private static function sanitizeAndValidateString(string $value, int $maxLength, string $fieldName): string
    {
        $cleanValue = trim(strip_tags($value));

        if (mb_strlen($cleanValue, 'UTF-8') > $maxLength) {
            throw new InvalidArgumentException("O campo {$fieldName} não pode ultrapassar {$maxLength} caracteres.");
        }
        
        return $cleanValue;
    }
}