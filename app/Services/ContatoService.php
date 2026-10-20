<?php

namespace App\Services;

use App\Controllers\DTOs\ContatoDTO;
use App\Controllers\DTOs\ContatoListaDTO;
use App\Controllers\DTOs\ListaMetadadosDTO;
use App\Models\Contato;
use App\Repositories\ContatoRepository;
use App\ValueObjects\DataNascimentoVO;
use App\ValueObjects\EnderecoVO;
use DateTime;
use InvalidArgumentException;

class ContatoService
{
    public function __construct(
        private ContatoRepository $repository
    ) { }

    /**
     * Lista os contatos por página, com limite
     * @param int $pagina
     * @param int $limite
     * @return ContatoListaDTO
     */
    public function listar(int $pagina = 1, int $limite = 10): ContatoListaDTO
    {
        $pagina = max(1, $pagina);
        $offset = ($pagina - 1) * $limite;

        $contatos = array_map(
            fn($contato) => $this->mapEntityToDTO($contato),
            $this->repository->getAll($limite, $offset)
        );

        $totalRegistros = $this->repository->countActive();

        return new ContatoListaDTO(
            $contatos,
            new ListaMetadadosDTO(
                totalRegistros: $totalRegistros,
                paginaAtual: $pagina,
                registrosPorPagina: $limite,
                totalPaginas: ($totalRegistros / $limite)
            )
        );
    }

    /**
     * Busca um contato por id
     * @param int $id
     * @return Contato|null
     */
    public function buscarPorId(int $id): ?Contato
    {
        $contato = $this->repository->findById($id);
        if ($contato && $contato->getDeletedAt() !== null) {
            return null;
        }
        return $contato;
    }

    /**
     * Cria ou atualiza um contato
     * @param ContatoDTO $dto
     * @throws InvalidArgumentException
     * @return Contato
     */
    public function salvar(ContatoDTO $dto): Contato
    {
        $contato = $dto->id ? $this->buscarPorId($dto->id) : new Contato();
        if (!$contato) {
            throw new InvalidArgumentException("Contato não encontrado.");
        }

        $contato = $this->mapDTOToEntity($dto, $contato);
        $this->repository->save($contato);

        return $contato;
    }

    /**
     * Exclui um contato (soft delete)
     * @param int $id
     * @return void
     */
    public function excluir(int $id): void
    {
        $contato = $this->buscarPorId($id);
        if ($contato) {
            $contato->setDeletedAt(new DateTime());
            $this->repository->save($contato);
        }
    }

    /**
     * Converte \App\Models\Contato em \App\Controllers\DTOs\ContatoDTO
     * @param Contato $entity
     * @return ContatoDTO
     */
    private function mapEntityToDTO(Contato $entity): ContatoDTO
    {
        $data = [
            'id' => $entity->getId(),
            'nome' => $entity->getNome(),
            'data_nascimento' => $entity->getDataNascimento()->format('Y-m-d H:i:s'),
            'logradouro' => $entity->getEndereco() 
        ];
        return ContatoDTO::fromArray($data);
    }

    /**
     * Converte \App\Controllers\DTOs\ContatoDTO em \App\Models\Contato
     * @param ContatoDTO $dto
     * @param Contato $entity
     * @return Contato
     */
    private function mapDTOToEntity(ContatoDTO $dto, Contato $entity): Contato
    {
        $endereco = null;
        if ($dto->logradouro || $dto->numero || $dto->bairro || $dto->cidade || $dto->uf || $dto->cep) {
            $endereco = (new EnderecoVO(
                $dto->logradouro,
                $dto->numero,
                $dto->bairro, 
                $dto->cidade,
                $dto->uf,
                $dto->cep
            ))->getEnderecoFormatado();
        }

        $dataNascimento = null;
        if (!empty($dto->dataNascimento)) {
            $dataNascimento = (new DataNascimentoVO($dto->dataNascimento))->getData();
        }

        $entity->setNome(empty(trim($dto->nome)));
        $entity->setEndereco($endereco);
        $entity->setDataNascimento($dataNascimento);

        return $entity;
    }
}