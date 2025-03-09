<?php

namespace App\Entity;

use App\Repository\ListaPeliculaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ListaPeliculaRepository::class)]
#[ORM\Table(name: "lista_pelicula")]
class ListaPelicula
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Lista::class, inversedBy: "listaPeliculas")]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private Lista $lista;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Pelicula::class, inversedBy: "listaPeliculas")]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private Pelicula $pelicula;

    public function __construct(Lista $lista, Pelicula $pelicula)
    {
        $this->lista = $lista;
        $this->pelicula = $pelicula;
    }

    public function getLista(): Lista
    {
        return $this->lista;
    }

    public function setLista(Lista $lista): self
    {
        if ($this->lista !== $lista) { // Si la lista es diferente a la que ya está seteada
            $this->lista = $lista;
        }
        return $this;
    }

    public function getPelicula(): Pelicula
    {
        return $this->pelicula;
    }

    public function setPelicula(Pelicula $pelicula): self
    {
        if ($this->pelicula !== $pelicula) { // Si la película es diferente a la que ya está seteada
            $this->pelicula = $pelicula;
        }
        return $this;
    }
}
