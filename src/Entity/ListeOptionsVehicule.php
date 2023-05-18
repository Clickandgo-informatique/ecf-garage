<?php

namespace App\Entity;

use App\Repository\ListeOptionsVehiculeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ListeOptionsVehiculeRepository::class)]
class ListeOptionsVehicule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'listeOptionsVehicules')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vehicules $vehicule = null;

    #[ORM\ManyToOne(inversedBy: 'listeOptionsVehicules')]
    #[ORM\JoinColumn(nullable: false)]
    private ?OptionsVehicules $option_vehicule = null;

    #[ORM\OneToOne(mappedBy: 'liste_options', cascade: ['persist', 'remove'])]
    private ?Vehicules $vehicules = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVehicule(): ?Vehicules
    {
        return $this->vehicule;
    }

    public function setVehicule(?Vehicules $vehicule): self
    {
        $this->vehicule = $vehicule;

        return $this;
    }

    public function getOptionVehicule(): ?OptionsVehicules
    {
        return $this->option_vehicule;
    }

    public function setOptionVehicule(?OptionsVehicules $option_vehicule): self
    {
        $this->option_vehicule = $option_vehicule;

        return $this;
    }

    public function getVehicules(): ?Vehicules
    {
        return $this->vehicules;
    }

    public function setVehicules(?Vehicules $vehicules): self
    {
        // unset the owning side of the relation if necessary
        if ($vehicules === null && $this->vehicules !== null) {
            $this->vehicules->setListeOptions(null);
        }

        // set the owning side of the relation if necessary
        if ($vehicules !== null && $vehicules->getListeOptions() !== $this) {
            $vehicules->setListeOptions($this);
        }

        $this->vehicules = $vehicules;

        return $this;
    }
}
