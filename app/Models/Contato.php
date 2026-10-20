<?php

namespace App\Models;

use App\Traits\DBAuditoriaTrait;
use App\ValueObjects\DataNascimentoVO;
use App\ValueObjects\EnderecoVO;
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
        $this->nome = $this->formatToDB($nome);
        return $this;
    }

    public function getEndereco(): ?string
    {
        return $this->endereco;
    }

    public function setEndereco(?EnderecoVO $endereco): self
    {
        $this->endereco = $endereco ? $this->formatToDB($endereco->getEnderecoFormatado()) : null;
        return $this;
    }

    public function getDataNascimento(): ?DateTimeInterface
    {
        return $this->dataNascimento;
    }

    public function setDataNascimento(?DataNascimentoVO $dataNascimento): self
    {
        $this->dataNascimento = $dataNascimento ? $dataNascimento->getData() : null;
        return $this;
    }

    /**
     * Higieniza uma string removendo excesso de espaços e transformando em uppercase
     *
     * @param string $content
     * @return string
     */
    private function formatToDB(string $content): string
    {
        $higienizado = trim(preg_replace('/\s+/', ' ', $content));
        return mb_strtoupper($higienizado, 'UTF-8');
    }
}
