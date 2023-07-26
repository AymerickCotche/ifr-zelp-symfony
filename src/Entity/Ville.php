<?php

namespace App\Entity;

use App\Repository\VilleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VilleRepository::class)]
class Ville
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 10)]
    private ?string $code_postal = null;

    #[ORM\OneToMany(mappedBy: 'ville_id', targetEntity: User::class)]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'ville_id', targetEntity: Restaurant::class)]
    private Collection $restaurants;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->restaurants = new ArrayCollection();
    }
    public function __toString()
    {
      return $this->name;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(string $code_postal): static
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setVilleId($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getVilleId() === $this) {
                $user->setVilleId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Restaurant>
     */
    public function getRestaurants(): Collection
    {
        return $this->restaurants;
    }

    public function addRestaurant(Restaurant $restaurantId): static
    {
        if (!$this->restaurants->contains($restaurantId)) {
            $this->restaurants->add($restaurantId);
            $restaurantId->setVilleId($this);
        }

        return $this;
    }

    public function removeRestaurant(Restaurant $restaurantId): static
    {
        if ($this->restaurants->removeElement($restaurantId)) {
            // set the owning side to null (unless already changed)
            if ($restaurantId->getVilleId() === $this) {
                $restaurantId->setVilleId(null);
            }
        }

        return $this;
    }
}
