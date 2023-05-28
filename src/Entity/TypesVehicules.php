<?php

namespace App\Entity;

use App\Repository\TypesVehiculesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity('nom_type','Ce type de véhicule existe déjà dans la base')]
#[ORM\Entity(repositoryClass: TypesVehiculesRepository::class)]
class TypesVehicules
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom_type = null;

    public function __toString()
    {
        return $this->nom_type;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomType(): ?string
    {
        return $this->nom_type;
    }

    public function setNomType(string $nom_type): self
    {
        $this->nom_type = $nom_type;

        return $this;
    }
}
