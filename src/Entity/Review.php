<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
#[ORM\Table(name: "review")]
class Review
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Usuario::class, inversedBy: "reviews")]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private Usuario $usuario;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Pelicula::class, inversedBy: "reviews")]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private Pelicula $pelicula;

    #[ORM\Column(type: "boolean", options: ["default" => false])]
    private bool $vista = false;

    #[ORM\Column(type: "integer", nullable: true)]
    #[Assert\Range(
        min: 1,
        max: 10,
        notInRangeMessage: "La nota debe estar entre {{ min }} y {{ max }}."
    )]
    private ?int $nota = null;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $comentario = null;

    #[ORM\Column(options: ["default" => "CURRENT_TIMESTAMP"])]
    private \DateTime $createdAt;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $modifiedAt = null;

    public function __construct()
    {
        $this->createdAt = new DateTime(); // Se inicializa automáticamente
    }

    public function getUsuario(): Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(Usuario $usuario): self
    {
        $this->usuario = $usuario;
        return $this;
    }

    public function getPelicula(): Pelicula
    {
        return $this->pelicula;
    }

    public function setPelicula(Pelicula $pelicula): self
    {
        $this->pelicula = $pelicula;
        return $this;
    }

    public function isVista(): bool
    {
        return $this->vista;
    }

    public function setVista(bool $vista): self
    {
        $this->vista = $vista;
        $this->updateModifiedAt();
        return $this;
    }

    public function getNota(): ?int
    {
        return $this->nota;
    }

    public function setNota(?int $nota): self
    {
        if ($nota !== null && ($nota < 1 || $nota > 10)) {
            throw new \InvalidArgumentException("La nota debe estar entre 1 y 10.");
        }
        $this->nota = $nota;
        $this->updateModifiedAt();
        return $this;
    }

    public function getComentario(): ?string
    {
        return $this->comentario;
    }

    public function setComentario(?string $comentario): self
    {
        $this->comentario = $comentario;
        $this->updateModifiedAt();
        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getModifiedAt(): ?\DateTime
    {
        return $this->modifiedAt;
    }

    private function updateModifiedAt(): void
    {
        $this->modifiedAt = new DateTime();
    }
}
