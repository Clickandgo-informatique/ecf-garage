<?php

namespace App\Entity;

use App\Repository\MotorisationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: MotorisationsRepository::class)]
#[UniqueEntity(fields: 'nom_motorisation', message: 'Cette motorisation existe déjà dans la base.')]

class Motorisations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_motorisation = null;

    #[ORM\OneToMany(mappedBy: 'motorisation', targetEntity: Vehicules::class, orphanRemoval: true)]
    private Collection $vehicules;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    public function __construct()
    {
        $this->vehicules = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->nom_motorisation;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomMotorisation(): ?string
    {
        return $this->nom_motorisation;
    }

    public function setNomMotorisation(string $nom_motorisation): self
    {
        $this->nom_motorisation = $nom_motorisation;

        return $this;
    }

    /**
     * @return Collection<int, Vehicules>
     */
    public function getVehicules(): Collection
    {
        return $this->vehicules;
    }

    public function addVehicule(Vehicules $vehicule): self
    {
        if (!$this->vehicules->contains($vehicule)) {
            $this->vehicules->add($vehicule);
            $vehicule->setMotorisation($this);
        }

        return $this;
    }

    public function removeVehicule(Vehicules $vehicule): self
    {
        if ($this->vehicules->removeElement($vehicule)) {
            // set the owning side to null (unless already changed)
            if ($vehicule->getMotorisation() === $this) {
                $vehicule->setMotorisation(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
