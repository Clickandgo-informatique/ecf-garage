<?php

namespace App\Entity;

use App\Repository\BoitesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity(fields:'description_boite',message:'Ce type de boîte est déjà présent dans la base !.')]
#[ORM\Entity(repositoryClass: BoitesRepository::class)]
class Boites
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description_boite = null;

    #[ORM\OneToMany(mappedBy: 'boite', targetEntity: Vehicules::class, orphanRemoval: true)]
    private Collection $vehicules;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    public function __tostring(): string
    {
        return $this->description_boite;
    }
    public function __construct()
    {
        $this->vehicules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescriptionBoite(): ?string
    {
        return $this->description_boite;
    }

    public function setDescriptionBoite(string $description_boite): self
    {
        $this->description_boite = $description_boite;

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
            $vehicule->setBoite($this);
        }

        return $this;
    }

    public function removeVehicule(Vehicules $vehicule): self
    {
        if ($this->vehicules->removeElement($vehicule)) {
            // set the owning side to null (unless already changed)
            if ($vehicule->getBoite() === $this) {
                $vehicule->setBoite(null);
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
