<?php

namespace App\Repository;

use App\Entity\Creneaux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;

/**
 * @extends ServiceEntityRepository<Creneaux>
 *
 * @method Creneaux|null find($id, $lockMode = null, $lockVersion = null)
 * @method Creneaux|null findOneBy(array $criteria, array $orderBy = null)
 * @method Creneaux[]    findAll()
 * @method Creneaux[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CreneauxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Creneaux::class);
    }

    public function save(Creneaux $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Creneaux $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function verifierCreneau(string $jour, $debut, $fin)
    {
        //Recherche du jour actif dans le formulaire

        return $this->createQueryBuilder('c')
            ->where('c.jour = :jour')
            ->andWhere(':debut between c.debut and c.fin')
            ->setparameters(['jour' => $jour, 'debut' => $debut->format("H:i")])
            ->getQuery()
            ->getResult();
    }

    public function getJourCreneaux()
    {
        //Recherche du numéro de jour actuel
        $jourActuel = date("w");

        switch ($jourActuel) {
            case 01:
                $jour = "Lundi";
                break;
            case 02:
                $jour = "Mardi";
                break;
            case 03:
                $jour = "Mercredi";
                break;
            case 04:
                $jour = "Jeudi";
                break;
            case 05:
                $jour = "Vendredi";
                break;
            case 06:
                $jour = "Samedi";
                break;
            case 00:
                $jour = "Dimanche";
                break;
            default:
                return false;
        }
        return $jour;
    }

    public function getCreneauxActifsJour()
    {
        //Recherche des créneaux enregistrés pour le jour et heure actuels
        $heuredebut = new \DateTime();
        $jour = $this->getJourCreneaux();

        $creneauxActifsJour = $this->createQueryBuilder('c')
            ->where('c.jour= :jour')
            ->andWhere(':heuredebut between c.debut and c.fin')
            ->setparameters(['jour' => $jour, 'heuredebut' => $heuredebut->format("H:i")])
            ->getQuery()->getResult();

        return $creneauxActifsJour;
     
    }

    public function getProchainsCreneaux()
    {
        $heuredebut = new \DateTime();
        $jour = $this->getJourCreneaux();

        $prochainsCreneaux = $this->createQueryBuilder('c')
            ->where('c.jour= :jour')
            ->andWhere('c.debut >= :heuredebut')
            ->setparameters(['jour' => $jour, 'heuredebut' => $heuredebut->format("H:i")])
            ->getQuery()->getResult();
            
        return $prochainsCreneaux;
    }

    //Logique d'affichage selon l'instant actuel
    //Si il existe un créneau ouvert le signaler + signaler les créneaux du jour restants les plus proches


}
