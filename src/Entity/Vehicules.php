<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\SlugTrait;
use App\Repository\VehiculesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehiculesRepository::class)]
class Vehicules
{
    use CreatedAtTrait;
    use SlugTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

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

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_mise_en_circulation = null;

    #[ORM\Column(nullable: true)]
    private ?int $nb_places = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_mise_en_vente = null;

    #[ORM\OneToMany(mappedBy: 'id_vehicule', targetEntity: Photos::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $photos;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $boite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $num_chassis = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $localisation = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_vente = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $critere_pollution = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_controle_technique = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $remarques = null;

    #[ORM\Column(nullable: true)]
    private ?int $kilometrage = null;

    #[ORM\Column(nullable: true)]
    private ?int $nb_proprietaires = null;

    #[ORM\Column(nullable: true)]
    private ?float $chevaux_fiscaux = null;

    #[ORM\Column(nullable: true)]
    private ?float $chevaux_din = null;

    #[ORM\ManyToOne(inversedBy: 'vehicules')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Marques $marque = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $reference_interne = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $plaque_immatriculation = null;

    #[ORM\ManyToOne(inversedBy: 'vehicules')]
    private ?Clients $proprietaire = null;

    #[ORM\OneToMany(mappedBy: 'vehicule', targetEntity: ListeOptionsVehicule::class, orphanRemoval: true)]
    private Collection $listeOptionsVehicule;

    #[ORM\Column(nullable: true)]
    private ?bool $publication_annonce = null;

    #[ORM\ManyToOne(inversedBy: 'vehicules')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Couleurs $couleur = null;

    #[ORM\ManyToOne(inversedBy: 'vehicules')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypesVehicules $type_vehicule = null;

    #[ORM\ManyToMany(targetEntity: Users::class, inversedBy: 'favoris')]
    private Collection $favoris;

    #[ORM\OneToMany(mappedBy: 'vehicule', targetEntity: Commentaires::class, orphanRemoval: true)]
    private Collection $commentaires;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
        $this->listeOptionsVehicule = new ArrayCollection();     
        $this->created_at = new \DateTimeImmutable();
        $this->favoris = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
    public function getBoite(): ?string
    {
        return $this->boite;
    }

    public function setBoite(?string $boite): self
    {
        $this->boite = $boite;

        return $this;
    }

    public function getNumChassis(): ?string
    {
        return $this->num_chassis;
    }

    public function setNumChassis(?string $num_chassis): self
    {
        $this->num_chassis = $num_chassis;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(?string $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getDateVente(): ?\DateTimeInterface
    {
        return $this->date_vente;
    }

    public function setDateVente(?\DateTimeInterface $date_vente): self
    {
        $this->date_vente = $date_vente;

        return $this;
    }

    public function getCriterePollution(): ?string
    {
        return $this->critere_pollution;
    }

    public function setCriterePollution(?string $critere_pollution): self
    {
        $this->critere_pollution = $critere_pollution;

        return $this;
    }

    public function getDateControleTechnique(): ?\DateTimeInterface
    {
        return $this->date_controle_technique;
    }

    public function setDateControleTechnique(?\DateTimeInterface $date_controle_technique): self
    {
        $this->date_controle_technique = $date_controle_technique;

        return $this;
    }

    public function getRemarques(): ?string
    {
        return $this->remarques;
    }

    public function setRemarques(?string $remarques): self
    {
        $this->remarques = $remarques;

        return $this;
    }

    public function getKilometrage(): ?int
    {
        return $this->kilometrage;
    }

    public function setKilometrage(?int $kilometrage): self
    {
        $this->kilometrage = $kilometrage;

        return $this;
    }

    public function getNbProprietaires(): ?int
    {
        return $this->nb_proprietaires;
    }

    public function setNbProprietaires(?int $nb_proprietaires): self
    {
        $this->nb_proprietaires = $nb_proprietaires;

        return $this;
    }

    public function getChevauxFiscaux(): ?float
    {
        return $this->chevaux_fiscaux;
    }

    public function setChevauxFiscaux(?float $chevaux_fiscaux): self
    {
        $this->chevaux_fiscaux = $chevaux_fiscaux;

        return $this;
    }

    public function getChevauxDin(): ?float
    {
        return $this->chevaux_din;
    }

    public function setChevauxDin(?float $chevaux_din): self
    {
        $this->chevaux_din = $chevaux_din;

        return $this;
    }

    public function getMarque(): ?Marques
    {
        return $this->marque;
    }

    public function setMarque(?Marques $marque): self
    {
        $this->marque = $marque;

        return $this;
    }


    public function __toString(): string
    {
        return $this->marque;
    }


    public function getReferenceInterne(): ?string
    {
        return $this->reference_interne;
    }

    public function setReferenceInterne(?string $reference_interne): self
    {
        $this->reference_interne = $reference_interne;

        return $this;
    }

    public function getPlaqueImmatriculation(): ?string
    {
        return $this->plaque_immatriculation;
    }

    public function setPlaqueImmatriculation(?string $plaque_immatriculation): self
    {
        $this->plaque_immatriculation = $plaque_immatriculation;

        return $this;
    }

    public function getProprietaire(): ?Clients
    {
        return $this->proprietaire;
    }

    public function setProprietaire(?Clients $proprietaire): self
    {
        $this->proprietaire = $proprietaire;

        return $this;
    }

    /**
     * @return Collection<int, ListeOptionsVehicule>
     */
    public function getListeOptionsVehicule(): Collection
    {
        return $this->listeOptionsVehicule;
    }

    public function addListeOptionsVehicule(ListeOptionsVehicule $listeOptionsVehicule): self
    {
        if (!$this->listeOptionsVehicule->contains($listeOptionsVehicule)) {
            $this->listeOptionsVehicule->add($listeOptionsVehicule);
            $listeOptionsVehicule->setVehicule($this);
        }

        return $this;
    }

    public function removeListeOptionsVehicule(ListeOptionsVehicule $listeOptionsVehicule): self
    {
        if ($this->listeOptionsVehicule->removeElement($listeOptionsVehicule)) {
            // set the owning side to null (unless already changed)
            if ($listeOptionsVehicule->getVehicule() === $this) {
                $listeOptionsVehicule->setVehicule(null);
            }
        }

        return $this;
    }

    public function isPublicationAnnonce(): ?bool
    {
        return $this->publication_annonce;
    }

    public function setPublicationAnnonce(?bool $publication_annonce): self
    {
        $this->publication_annonce = $publication_annonce;

        return $this;
    }

    public function getCouleur(): ?Couleurs
    {
        return $this->couleur;
    }

    public function setCouleur(?Couleurs $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getTypeVehicule(): ?TypesVehicules
    {
        return $this->type_vehicule;
    }

    public function setTypeVehicule(?TypesVehicules $type_vehicule): self
    {
        $this->type_vehicule = $type_vehicule;

        return $this;
    }

    /**
     * @return Collection<int, Users>
     */
    public function getFavoris(): Collection
    {
        return $this->favoris;
    }

    public function addFavori(Users $favori): self
    {
        if (!$this->favoris->contains($favori)) {
            $this->favoris->add($favori);
        }

        return $this;
    }

    public function removeFavori(Users $favori): self
    {
        $this->favoris->removeElement($favori);

        return $this;
    }

    /**
     * @return Collection<int, Commentaires>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaires $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setVehicule($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaires $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getVehicule() === $this) {
                $commentaire->setVehicule(null);
            }
        }

        return $this;
    }
}
