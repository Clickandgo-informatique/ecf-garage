<?php

namespace App\Entity;

use App\Repository\MotorisationsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MotorisationsRepository::class)]
class Motorisations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_motorisation = null;

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
}
