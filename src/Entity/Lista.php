<?php

namespace App\Entity;

use App\Repository\ListaRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;

#[ORM\Entity(repositoryClass: ListaRepository::class)]
class Lista
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private string $nombre;

    // El tipo de lista puede ser 'default' o 'custom'
    // Por defecto, el tipo es 'custom'
    #[ORM\Column(length: 10, options: ["default" => "custom"])]
    #[Assert\Choice(choices: ["default", "custom"], message: "El tipo debe ser 'default' o 'custom'.")]
    private string $tipo = "custom";

    #[ORM\Column(type: "datetime", options: ["default" => "CURRENT_TIMESTAMP"])]
    private DateTime $createdAt;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?DateTime $modifiedAt = null;

    // inversedBy le dice a Doctrine que la relación tiene una contraparte en la entidad Usuario, llamada listas
    // permite acceder a todas las listas de un usuario desde la entidad Usuario.
    #[ORM\ManyToOne(targetEntity: Usuario::class, inversedBy: 'listas')]
    #[ORM\JoinColumn(nullable: true, onDelete: "CASCADE")]
    private ?Usuario $usuario = null; // NULL para listas default

    // FK
    #[ORM\OneToMany(mappedBy: "lista", targetEntity: ListaPelicula::class, cascade: ["persist", "remove"])]
    private Collection $listaPeliculas;

    public function __construct()
    {
        $this->listaPeliculas = new ArrayCollection();
        $this->createdAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        if (!in_array($tipo, ['default', 'custom'])) {
            throw new \InvalidArgumentException("Tipo de lista no válido.");
        }
        $this->tipo = $tipo;
        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): self
    {
        $this->usuario = $usuario;
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
            $listaPelicula->setLista($this);
        }
        return $this;
    }

    public function removeListaPelicula(ListaPelicula $listaPelicula): self
    {
        if ($this->listaPeliculas->removeElement($listaPelicula)) {
            if ($listaPelicula->getLista() === $this) {
                $listaPelicula->setLista(null);
            }
        }
        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getModifiedAt(): ?DateTime
    {
        return $this->modifiedAt;
    }

    private function updateModifiedAt(): void
    {
        $this->modifiedAt = new DateTime();
    }
}
