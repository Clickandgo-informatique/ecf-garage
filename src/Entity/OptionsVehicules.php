<?php

namespace App\Entity;

use App\Repository\OptionsVehiculesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: OptionsVehiculesRepository::class)]
#[UniqueEntity('nom_option', 'Cette option de véhicule existe déjà dans la base.')]
class OptionsVehicules
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_option = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description_option = null;

    #[ORM\OneToMany(mappedBy: 'option_vehicule', targetEntity: ListeOptionsVehicule::class, orphanRemoval: true)]
    private Collection $listeOptionsVehicules;

    #[ORM\OneToOne(mappedBy: 'option_vehicule', cascade: ['persist', 'remove'])]
    private ?ListeOptionsVehicule $listeOptionsVehicule = null;

    public function __construct()
    {
        $this->listeOptionsVehicules = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomOption(): ?string
    {
        return $this->nom_option;
    }

    public function setNomOption(string $nom_option): self
    {
        $this->nom_option = $nom_option;
        return $this;
    }

    public function __toString(): string
    {
        return $this->nom_option;
    }

    public function getDescriptionOption(): ?string
    {
        return $this->description_option;
    }

    public function setDescriptionOption(?string $description_option): self
    {
        $this->description_option = $description_option;

        return $this;
    }

    /**
     * @return Collection<int, ListeOptionsVehicule>
     */
    public function getListeOptionsVehicules(): Collection
    {
        return $this->listeOptionsVehicules;
    }

    public function addListeOptionsVehicule(ListeOptionsVehicule $listeOptionsVehicule): self
    {
        if (!$this->listeOptionsVehicules->contains($listeOptionsVehicule)) {
            $this->listeOptionsVehicules->add($listeOptionsVehicule);
            $listeOptionsVehicule->setOptionVehicule($this);
        }

        return $this;
    }

    public function removeListeOptionsVehicule(ListeOptionsVehicule $listeOptionsVehicule): self
    {
        if ($this->listeOptionsVehicules->removeElement($listeOptionsVehicule)) {
            // set the owning side to null (unless already changed)
            if ($listeOptionsVehicule->getOptionVehicule() === $this) {
                $listeOptionsVehicule->setOptionVehicule(null);
            }
        }

        return $this;
    }

    public function getListeOptionsVehicule(): ?ListeOptionsVehicule
    {
        return $this->listeOptionsVehicule;
    }

    public function setListeOptionsVehicule(ListeOptionsVehicule $listeOptionsVehicule): self
    {
        // set the owning side of the relation if necessary
        if ($listeOptionsVehicule->getOptionVehicule() !== $this) {
            $listeOptionsVehicule->setOptionVehicule($this);
        }

        $this->listeOptionsVehicule = $listeOptionsVehicule;

        return $this;
    }
}
