<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: "usuario")]
#[UniqueEntity(fields: ['email'], message: 'Este email ya está registrado.')]
class Usuario implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 2,
        minMessage: 'El nombre debe tener al menos {{ limit }} caracteres.'
    )]
    private ?string $nombre = null;

    #[Assert\NotBlank]
    #[Assert\Email]
    #[ORM\Column(type: "string", length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column(type: "json")]
    private array $roles = ['ROLE_USER'];

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 6,
        minMessage: 'La contraseña debe tener al menos {{ limit }} caracteres'
    )]
    #[ORM\Column(type: "string")]
    private ?string $password = null;

    #[ORM\Column(type: 'boolean')]
    private bool $isVerified = false;

    // mappedBy se refiere a la propiedad en la entidad relacionada
    // targetEntity se refiere a la entidad relacionada
    // permite acceder a el usuario al que pertenece una lista desde la entidad Lista.
    #[ORM\OneToMany(mappedBy: 'usuario', targetEntity: Lista::class, cascade: ['persist', 'remove'])]
    private Collection $listas;

    #[ORM\OneToMany(mappedBy: "usuario", targetEntity: Review::class, cascade: ["persist", "remove"])]
    private Collection $reviews;

    // Constructor
    public function __construct()
    {
        $this->listas = new ArrayCollection();
        $this->reviews = new ArrayCollection();
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $status): void
    {
        $this->isVerified = $status;
    }

    public function eraseCredentials(): void
    {
        // Si almacenas datos temporales sensibles, límpialos aquí
        // Implementar esta función más adelante
    }

    // Getters y Setters para listas
    public function getListas(): Collection
    {
        return $this->listas;
    }

    public function addLista(Lista $lista): self
    {
        if (!$this->listas->contains($lista)) {
            $this->listas->add($lista);
            $lista->setUsuario($this);
        }
        return $this;
    }

    public function removeLista(Lista $lista): self
    {
        if ($this->listas->removeElement($lista)) {
            if ($lista->getUsuario() === $this) {
                $lista->setUsuario(null);
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
            $review->setUsuario($this);
        }
        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            if ($review->getUsuario() === $this) {
                $review->setUsuario(null);
            }
        }
        return $this;
    }
}
