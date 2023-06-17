<?php

namespace App\Entity;

use App\Repository\CouleursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouleursRepository::class)]
class Couleurs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $couleur = null;

    #[ORM\OneToMany(mappedBy: 'couleur', targetEntity: Vehicules::class, orphanRemoval: true)]
    private Collection $vehicules;

    public function __construct()
    {
        $this->vehicules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function __toString():string
    {
        return $this->couleur;
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
            $vehicule->setCouleur($this);
        }

        return $this;
    }

    public function removeVehicule(Vehicules $vehicule): self
    {
        if ($this->vehicules->removeElement($vehicule)) {
            // set the owning side to null (unless already changed)
            if ($vehicule->getCouleur() === $this) {
                $vehicule->setCouleur(null);
            }
        }

        return $this;
    }
}
