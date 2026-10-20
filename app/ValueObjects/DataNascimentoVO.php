<?php

namespace App\ValueObjects;

use DateTime;
use DateTimeInterface;
use InvalidArgumentException;

class DataNascimentoVO
{
    private DateTimeInterface $data;

    /**
     * Se os limites de validação forem informados, considera a máxima como data atual e a mínima como hoje - 120 anos.
     */
    public function __construct(
        string $dataNascimento, 
        ?DateTimeInterface $dataMinima = null, 
        ?DateTimeInterface $dataMaxima = null
    ) {
        $dataObj = DateTime::createFromFormat('Y-m-d', $dataNascimento);
        
        if (!$dataObj || $dataObj->format('Y-m-d') !== $dataNascimento) {
            throw new InvalidArgumentException("Data de nascimento inválida. Use o formato YYYY-MM-DD.");
        }

        $dataMaxima = $dataMaxima ?? new DateTime(); // Hoje
        $dataMinima = $dataMinima ?? (new DateTime())->modify('-120 years');

        if ($dataObj > $dataMaxima) {
            throw new InvalidArgumentException("A data de nascimento não pode ser uma data futura.");
        }

        if ($dataObj < $dataMinima) {
            throw new InvalidArgumentException("A data de nascimento excede o limite máximo de 120 anos.");
        }

        $this->data = $dataObj;
    }

    public function getData(): DateTimeInterface
    {
        return $this->data;
    }
}