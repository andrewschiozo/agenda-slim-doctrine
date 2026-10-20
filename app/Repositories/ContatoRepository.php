<?php

namespace App\Repositories;

use App\Models\Contato;
use Doctrine\ORM\EntityManager;

class ContatoRepository
{
    public function __construct(
        private EntityManager $entityManager
    ) { }

    /**
     * Retorna os contatos ativos
     * @param int $limit
     * @param int $offset
     * @return array<Contato>
     */
    public function getAll(int $limit, int $offset): array
    {
        return $this->entityManager->createQueryBuilder()
            ->select('c')
            ->from(Contato::class, 'c')
            ->where('c.deletedAt IS NULL')
            ->setMaxResults($limit)   // LIMIT
            ->setFirstResult($offset) // OFFSET
            ->getQuery()
            ->getResult();
    }

    /**
     * Conta o total de contatos ativos
     * @return int
     */
    public function countActive(): int
    {
        return (int) $this->entityManager->createQueryBuilder()
            ->select('COUNT(c.id)')
            ->from(Contato::class, 'c')
            ->where('c.deletedAt IS NULL')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Busca um contato por id
     * @param int $id
     * @return Contato|null
     */
    public function findById(int $id): ?Contato
    {
        return $this->entityManager->getRepository(Contato::class)->find($id);
    }

    /**
     * Cria ou atualiza um contato
     * @param Contato $contato
     * @return void
     */
    public function save(Contato $contato): void
    {
        $this->entityManager->persist($contato);
        $this->entityManager->flush();
    }
}