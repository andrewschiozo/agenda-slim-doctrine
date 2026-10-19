<?php

namespace App\Models;

use App\Traits\DBAuditoriaTrait;
use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;

#[ORM\Entity]
#[ORM\Table(name: 'contatos')]
#[ORM\HasLifecycleCallbacks]
class Contato
{
    use DBAuditoriaTrait;

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $nome;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $endereco = null;

    #[ORM\Column(name: 'data_nascimento', type: 'date', nullable: true)]
    private ?DateTimeInterface $dataNascimento = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;
        return $this;
    }

    public function getEndereco(): ?string
    {
        return $this->endereco;
    }

    public function setEndereco(?string $endereco): self
    {
        $this->endereco = $endereco;
        return $this;
    }

    public function getDataNascimento(): ?DateTimeInterface
    {
        return $this->dataNascimento;
    }

    public function setDataNascimento(?DateTimeInterface $dataNascimento): self
    {
        $this->dataNascimento = $dataNascimento;
        return $this;
    }
}
