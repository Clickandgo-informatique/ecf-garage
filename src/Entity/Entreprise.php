<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntrepriseRepository::class)]

class Entreprise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_entreprise = null;

    #[ORM\Column(length: 9)]
    private ?string $siren = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(length: 5)]
    private ?string $codepostal = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $gerant = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ville = null;

    #[ORM\Column(length: 16, nullable: true)]
    private ?string $tel1 = null;

    #[ORM\Column(length: 16, nullable: true)]
    private ?string $tel2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mail_principal = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mail_secondaire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEntreprise(): ?string
    {
        return $this->nom_entreprise;
    }

    public function setNomEntreprise(string $nom_entreprise): self
    {
        $this->nom_entreprise = $nom_entreprise;

        return $this;
    }

    public function getsiren(): ?string
    {
        return $this->siren;
    }

    public function setsiren(string $siren): self
    {
        $this->siren = $siren;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodepostal(): ?string
    {
        return $this->codepostal;
    }

    public function setCodepostal(string $codepostal): self
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    public function getGerant(): ?string
    {
        return $this->gerant;
    }

    public function setGerant(?string $gerant): self
    {
        $this->gerant = $gerant;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getTel1(): ?string
    {
        return $this->tel1;
    }

    public function setTel1(?string $tel1): self
    {
        $this->tel1 = $tel1;

        return $this;
    }

    public function getTel2(): ?string
    {
        return $this->tel2;
    }

    public function setTel2(?string $tel2): self
    {
        $this->tel2 = $tel2;

        return $this;
    }

    public function getMailprincipal(): ?string
    {
        return $this->mail_principal;
    }

    public function setMailprincipal(?string $mailprincipal): self
    {
        $this->mail_principal = $mailprincipal;

        return $this;
    }

    public function getMailsecondaire(): ?string
    {
        return $this->mail_secondaire;
    }

    public function setMailsecondaire(?string $mailsecondaire): self
    {
        $this->mail_secondaire = $mailsecondaire;

        return $this;
    }
}
