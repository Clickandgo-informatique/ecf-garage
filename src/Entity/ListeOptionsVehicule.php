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

    #[ORM\ManyToOne(inversedBy: 'listeOptionsVehicule')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vehicules $vehicule = null;

    #[ORM\ManyToOne(inversedBy: 'listeOptionsVehicule', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?OptionsVehicules $option_vehicule = null;
    
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
    public function __tostring():string{
        return $this->option_vehicule;
    }
}
