<?php

namespace App\Entity;

use App\Repository\VehiculesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehiculesRepository::class)]
class Vehicules
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $marque = null;

    #[ORM\Column(length: 100)]
    private ?string $modele = null;

    #[ORM\Column(length: 100)]
    private ?string $motorisation = null;

    #[ORM\Column(nullable: true)]
    private ?int $cylindree = null;

    #[ORM\Column(nullable: true)]
    private ?int $nb_portes = null;

    #[ORM\Column]
    private ?int $prix_vente = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $couleur = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_mise_en_circulation = null;

    #[ORM\Column(nullable: true)]
    private ?int $nb_places = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_mise_en_vente = null;

    #[ORM\OneToMany(mappedBy: 'id_vehicule', targetEntity: Photos::class, orphanRemoval: true)]
    private Collection $photos;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $type_vehicule = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $boite = null;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    public function getMotorisation(): ?string
    {
        return $this->motorisation;
    }

    public function setMotorisation(string $motorisation): self
    {
        $this->motorisation = $motorisation;

        return $this;
    }

    public function getCylindree(): ?int
    {
        return $this->cylindree;
    }

    public function setCylindree(?int $cylindree): self
    {
        $this->cylindree = $cylindree;

        return $this;
    }

    public function getNbPortes(): ?int
    {
        return $this->nb_portes;
    }

    public function setNbPortes(?int $nb_portes): self
    {
        $this->nb_portes = $nb_portes;

        return $this;
    }

    public function getPrixVente(): ?int
    {
        return $this->prix_vente;
    }

    public function setPrixVente(int $prix_vente): self
    {
        $this->prix_vente = $prix_vente;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(?string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getDateMiseEnCirculation(): ?\DateTimeInterface
    {
        return $this->date_mise_en_circulation;
    }

    public function setDateMiseEnCirculation(?\DateTimeInterface $date_mise_en_circulation): self
    {
        $this->date_mise_en_circulation = $date_mise_en_circulation;

        return $this;
    }

    public function getNbPlaces(): ?int
    {
        return $this->nb_places;
    }

    public function setNbPlaces(?int $nb_places): self
    {
        $this->nb_places = $nb_places;

        return $this;
    }

    public function getDateMiseEnVente(): ?\DateTimeInterface
    {
        return $this->date_mise_en_vente;
    }

    public function setDateMiseEnVente(?\DateTimeInterface $date_mise_en_vente): self
    {
        $this->date_mise_en_vente = $date_mise_en_vente;

        return $this;
    }

    /**
     * @return Collection<int, Photos>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photos $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos->add($photo);
            $photo->setIdVehicule($this);
        }

        return $this;
    }

    public function removePhoto(Photos $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getIdVehicule() === $this) {
                $photo->setIdVehicule(null);
            }
        }

        return $this;
    }

    public function getTypeVehicule(): ?string
    {
        return $this->type_vehicule;
    }

    public function setTypeVehicule(?string $type_vehicule): self
    {
        $this->type_vehicule = $type_vehicule;

        return $this;
    }

    public function getBoite(): ?string
    {
        return $this->boite;
    }

    public function setBoite(?string $boite): self
    {
        $this->boite = $boite;

        return $this;
    }
}
