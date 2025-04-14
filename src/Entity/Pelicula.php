<?php

namespace App\Entity;

use App\Repository\PeliculaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: PeliculaRepository::class)]
class Pelicula
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $titulo = null;

    #[ORM\Column]
    private ?int $anio = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $sinopsis = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imagen = null;

    #[ORM\Column(options: ["default" => "CURRENT_TIMESTAMP"])]
    private \DateTime $createdAt;

    // FK
    #[ORM\OneToMany(mappedBy: "pelicula", targetEntity: ListaPelicula::class, cascade: ["persist", "remove"])]
    private Collection $listaPeliculas;

    // FK
    #[ORM\OneToMany(mappedBy: "pelicula", targetEntity: Review::class, cascade: ["persist", "remove"])]
    private Collection $reviews;

    public function __construct()
    {
        $this->createdAt = $this->createdAt ?? new \DateTime(); // Se inicializa automáticamente
        $this->listaPeliculas = new ArrayCollection();
        $this->reviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): static
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getAnio(): ?int
    {
        return $this->anio;
    }

    public function setAnio(int $anio): static
    {
        $this->anio = $anio;

        return $this;
    }

    public function getSinopsis(): ?string
    {
        return $this->sinopsis;
    }

    public function setSinopsis(?string $sinopsis): static
    {
        $this->sinopsis = $sinopsis;

        return $this;
    }

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(?string $imagen): static
    {
        $this->imagen = $imagen;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getListaPeliculas(): Collection
    {
        return $this->listaPeliculas;
    }

    public function addListaPelicula(ListaPelicula $listaPelicula): self
    {
        if (!$this->listaPeliculas->contains($listaPelicula)) {
            $this->listaPeliculas->add($listaPelicula);
            $listaPelicula->setPelicula($this);
        }
        return $this;
    }

    public function removeListaPelicula(ListaPelicula $listaPelicula): self
    {
        if ($this->listaPeliculas->removeElement($listaPelicula)) {
            if ($listaPelicula->getPelicula() === $this) {
                $listaPelicula->setPelicula(null);
            }
        }
        return $this;
    }

    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
        }
        return $this;
    }

    public function removeReview(Review $review): self
    {
        $this->reviews->removeElement($review);
        return $this;
    }
}
