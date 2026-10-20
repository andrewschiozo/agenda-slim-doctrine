<?php

namespace Tests\Unit\ValueObjects;

use App\ValueObjects\DataNascimentoVO;
use DateTime;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class DataNascimentoVOTest extends TestCase
{
    /**
     * Testa o cenário de criação de uma data válida
     */
    public function testDeveCriarDataNascimentoComSucesso(): void
    {
        $dataValida = '2005-04-16';
        $vo = new DataNascimentoVO($dataValida);
        
        $this->assertEquals($dataValida, $vo->getData()->format('Y-m-d'));
    }

    /**
     * Testa múltiplos cenários de erro
     */
    #[DataProvider('datasInvalidasProvider')]
    public function testDeveLancarExcecaoParaDatasInvalidas(string $data, string $mensagemEsperada): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($mensagemEsperada);

        // O construtor do VO exige apenas a data; os limites de validação aplicam-se opcionalmente ou por defeito.
        new DataNascimentoVO($data);
    }

    /**
     * Fornece os cenários de falha esperados para a validação da data.
     */
    public static function datasInvalidasProvider(): array
    {
        $amanha = (new DateTime('+1 day'))->format('Y-m-d');
        $passadoDistante = (new DateTime('-121 years'))->format('Y-m-d');

        return [
            'Formato inválido (PT)' => ['16/04/2005', 'Data de nascimento inválida. Use o formato YYYY-MM-DD.'],
            'Formato inválido (Letras)' => ['abc', 'Data de nascimento inválida. Use o formato YYYY-MM-DD.'],
            'Data no futuro' => [$amanha, 'A data de nascimento não pode ser uma data futura.'],
            'Idade acima de 120 anos' => [$passadoDistante, 'A data de nascimento excede o limite máximo de 120 anos.'],
        ];
    }
}