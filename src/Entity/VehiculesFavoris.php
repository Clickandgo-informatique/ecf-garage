<?php

namespace App\Entity;

use App\Repository\VehiculesFavorisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehiculesFavorisRepository::class)]
class VehiculesFavoris
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Vehicules::class, inversedBy: 'favoris')]
    private Collection $vehicule;

    public function __construct()
    {
        $this->vehicule = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Vehicules>
     */
    public function getVehicule(): Collection
    {
        return $this->vehicule;
    }

    public function addVehicule(Vehicules $vehicule): self
    {
        if (!$this->vehicule->contains($vehicule)) {
            $this->vehicule->add($vehicule);
        }

        return $this;
    }

    public function removeVehicule(Vehicules $vehicule): self
    {
        $this->vehicule->removeElement($vehicule);

        return $this;
    }
}
