<?php

namespace App\ValueObjects;

class EnderecoVO
{
    private string $enderecoFormatado;

    public function __construct(
        ?string $logradouro,
        ?string $numero,
        ?string $bairro,
        ?string $cidade,
        ?string $uf,
        ?string $cep
    ) {
        $this->enderecoFormatado = $this->montarEndereco(
            $logradouro, $numero, $bairro, $cidade, $uf, $cep
        );
    }

    private function montarEndereco(
        ?string $logradouro,
        ?string $numero,
        ?string $bairro, 
        ?string $cidade,
        ?string $uf,
        ?string $cep
    ): string {
        $partes = [];

        $ruaNum = trim((string)$logradouro);
        if (!empty($numero)) {
            $ruaNum .= empty($ruaNum) ? $numero : ', ' . trim($numero);
        }
        if (!empty($ruaNum)) $partes[] = $ruaNum;

        // Bairro
        if (!empty($bairro)) $partes[] = trim($bairro);

        // Cidade/UF
        $cidadeUf = trim((string)$cidade);
        if (!empty($uf)) {
            $cidadeUf .= empty($cidadeUf) ? trim($uf) : '/' . trim($uf);
        }
        if (!empty($cidadeUf)) $partes[] = $cidadeUf;

        // CEP
        if (!empty($cep)) $partes[] = 'CEP: ' . trim($cep);

        return implode(' - ', $partes);
    }

    public function getEnderecoFormatado(): string
    {
        return $this->enderecoFormatado;
    }
}