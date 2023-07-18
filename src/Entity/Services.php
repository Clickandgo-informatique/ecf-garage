<?php

namespace App\Entity;

use App\Repository\ServicesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ServicesRepository::class)]
#[UniqueEntity('nom',"Il existe déjà un service portant ce nom dans la base, veuillez rectifier le nom svp.")]    

class Services
{ 
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT, nullable: false)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?float $prix_a_partir_de = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $icone = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    private ?string $resume = null;

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: Telephones::class)]
    private Collection $telephones;

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: Mails::class)]
    private Collection $mails;

    #[ORM\Column(length: 16, nullable: true)]
    private ?string $telephone_1 = null;

    #[ORM\Column(length: 16, nullable: true)]
    private ?string $telephone_2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $responsable = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mail_service_1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mail_service_2 = null;

    #[ORM\Column]
    private ?bool $afficher = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $civilite_responsable = null;

    public function __toString()
    {
        return $this->nom;
    }

    public function __construct()
    {
        $this->telephones = new ArrayCollection();
        $this->mails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrixAPartirDe(): ?float
    {
        return $this->prix_a_partir_de;
    }

    public function setPrixAPartirDe(?float $prix_a_partir_de): self
    {
        $this->prix_a_partir_de = $prix_a_partir_de;

        return $this;
    }

    public function getIcone(): ?string
    {
        return $this->icone;
    }

    public function setIcone(?string $icone): self
    {
        $this->icone = $icone;

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

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    /**
     * @return Collection<int, Telephones>
     */
    public function getTelephones(): Collection
    {
        return $this->telephones;
    }

    public function addTelephone(Telephones $telephone): self
    {
        if (!$this->telephones->contains($telephone)) {
            $this->telephones->add($telephone);
            $telephone->setService($this);
        }

        return $this;
    }

    public function removeTelephone(Telephones $telephone): self
    {
        if ($this->telephones->removeElement($telephone)) {
            // set the owning side to null (unless already changed)
            if ($telephone->getService() === $this) {
                $telephone->setService(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Mails>
     */
    public function getMails(): Collection
    {
        return $this->mails;
    }

    public function addMail(Mails $mail): self
    {
        if (!$this->mails->contains($mail)) {
            $this->mails->add($mail);
            $mail->setService($this);
        }

        return $this;
    }

    public function removeMail(Mails $mail): self
    {
        if ($this->mails->removeElement($mail)) {
            // set the owning side to null (unless already changed)
            if ($mail->getService() === $this) {
                $mail->setService(null);
            }
        }

        return $this;
    }

    public function getTelephone1(): ?string
    {
        return $this->telephone_1;
    }

    public function setTelephone1(?string $telephone_1): self
    {
        $this->telephone_1 = $telephone_1;

        return $this;
    }

    public function getTelephone2(): ?string
    {
        return $this->telephone_2;
    }

    public function setTelephone2(?string $telephone_2): self
    {
        $this->telephone_2 = $telephone_2;

        return $this;
    }

    public function getResponsable(): ?string
    {
        return $this->responsable;
    }

    public function setResponsable(?string $responsable): self
    {
        $this->responsable = $responsable;

        return $this;
    }

    public function getMailService1(): ?string
    {
        return $this->mail_service_1;
    }

    public function setMailService1(?string $mail_service_1): self
    {
        $this->mail_service_1 = $mail_service_1;

        return $this;
    }

    public function getMailService2(): ?string
    {
        return $this->mail_service_2;
    }

    public function setMailService2(?string $mail_service_2): self
    {
        $this->mail_service_2 = $mail_service_2;

        return $this;
    }

    public function isAfficher(): ?bool
    {
        return $this->afficher;
    }

    public function setAfficher(bool $afficher): self
    {
        $this->afficher = $afficher;

        return $this;
    }

    public function getCiviliteResponsable(): ?string
    {
        return $this->civilite_responsable;
    }

    public function setCiviliteResponsable(?string $civilite_responsable): self
    {
        $this->civilite_responsable = $civilite_responsable;

        return $this;
    }
}
