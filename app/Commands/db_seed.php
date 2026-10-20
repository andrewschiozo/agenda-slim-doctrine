<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\Contato;
use App\ValueObjects\DataNascimentoVO;
use App\ValueObjects\EnderecoVO;

$entityManager = require_once __DIR__ . '/../../config/doctrine.php';

echo "Iniciando o povoamento (Seed) do banco de dados...\n";

// Listas para gerar dados aleatórios
$nomes = ['Ana', 'Bruno', 'Carlos', 'Daniela', 'Eduardo', 'Fernanda', 'Gabriel', 'Helena', 'Igor', 'Juliana', 'Lucas', 'Mariana', 'Nicolas', 'Olivia', 'Pedro', 'Rafael', 'Sofia', 'Tiago', 'Vitoria', 'Wagner'];
$sobrenomes = ['Silva', 'Santos', 'Oliveira', 'Souza', 'Rodrigues', 'Ferreira', 'Alves', 'Pereira', 'Lima', 'Gomes', 'Costa', 'Ribeiro', 'Martins', 'Carvalho', 'Almeida'];
$ruas = ['Rua das Flores', 'Avenida Paulista', 'Rua Augusta', 'Avenida Brasil', 'Rua da Consolação', 'Avenida Ipiranga', 'Rua São João', 'Avenida Presidente Vargas'];
$bairros = ['Centro', 'Jardim América', 'Bela Vista', 'Pinheiros', 'Vila Madalena', 'Copacabana', 'Botafogo', 'Savassi'];
$cidadesUf = ['São Paulo - SP', 'Rio de Janeiro - RJ', 'Belo Horizonte - MG', 'Curitiba - PR', 'Porto Alegre - RS', 'Salvador - BA', 'Fortaleza - CE'];

$quantidade = 30;

try {
    for ($i = 1; $i <= $quantidade; $i++) {
        $contato = new Contato();

        $nomeAleatorio = 
            $nomes[array_rand($nomes)] . ' ' .
            $sobrenomes[array_rand($sobrenomes)] . ' ' .
            $sobrenomes[array_rand($sobrenomes)];

        $enderecoAleatorio =
            $ruas[array_rand($ruas)] . ', ' .
            rand(10, 9999) . ', ' .
            $bairros[array_rand($bairros)] . ' - ' .
            $cidadesUf[array_rand($cidadesUf)] .
            ' - CEP: 0' . rand(1000, 9999) . '-' . rand(100, 999);
        
        // data de nascimento aleatória (entre 18 e 60 anos atrás)
        $timestampNascimento = strtotime('-' . rand(18, 60) . ' years');
        $dataNascimento = new DateTime();
        $dataNascimento->setTimestamp($timestampNascimento);

        $contato->setNome($nomeAleatorio);
        $contato->setEndereco(new EnderecoVO($enderecoAleatorio, null, null, null, null, null));
        $contato->setDataNascimento(new DataNascimentoVO($dataNascimento->format('Y-m-d')));

        $entityManager->persist($contato);
    }

    // insert em massa
    $entityManager->flush();

    echo "Sucesso! {$quantidade} contatos foram inseridos no banco de dados.\n";
} catch (\Exception $e) {
    echo "Erro ao rodar a seed: " . $e->getMessage() . "\n";
}