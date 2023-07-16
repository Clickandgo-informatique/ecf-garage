<?php

namespace App\Repository;

use App\Entity\Vehicules;
use App\Utils\PaginationResult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vehicules>
 *
 * @method Vehicules|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vehicules|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vehicules[]    findAll()
 * @method Vehicules[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehiculesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicules::class);
    }

    public function save(Vehicules $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Vehicules $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //Pagination liste véhicules après filtre
    public function getVehiculesPaginated(int $page, int $limit = 10, $filtreTypes = null, $filtreMarques = null, int $prixMin = null, int $prixMax = null, int $kmMin = null, int $kmMax = null, $classerPar = null, $filtreMotorisations = null, $filtreBoites = null, $yearMin = null, $yearMax = null, $user = null)
    {
        $limit = abs($limit);

        $query = $this->createQueryBuilder('v');
        //Ne prend que les véhicules dont on a aprouvé la publication
        $query->where('v.publication_annonce = true');

        //Filtre sur types de véhicules
        if ($filtreTypes != null) {
            $query->where('v.type_vehicule IN (:types)')
                ->setParameter(':types', array_values($filtreTypes));
        }

        //Filtre sur marques de véhicules
        if ($filtreMarques != null) {
            $query->andWhere('v.marque IN(:marques)')
                ->setParameter(':marques', array_values($filtreMarques));
        }

        //Fitre sur motorisations
        if ($filtreMotorisations != null) {
            $query->andWhere('v.motorisation IN(:motorisations)')
                ->setParameter(':motorisations', array_values($filtreMotorisations));
        }
        //Fitre sur types de boîtes
        if ($filtreBoites != null) {
            $query->andWhere('v.boite IN(:boites)')
                ->setParameter(':boites', array_values($filtreBoites));
        }

        //Filtre sur intervalle de prix
        if (!empty($prixMin) && !empty($prixMax)) {
            $query->andWhere('v.prix_vente >= :prixMin and v.prix_vente <= :prixMax')
                ->setParameter(':prixMin', $prixMin)
                ->setParameter(':prixMax', $prixMax);
        }

        //Filtre sur intervalle de kilométrage
        if (!empty($kmMin) && $kmMin != null && !empty($kmMax) && $kmMax != null) {
            $query->andWhere('v.kilometrage >= :kmMin and v.kilometrage <= :kmMax')
                ->setParameter(':kmMin', $kmMin)
                ->setParameter(':kmMax', $kmMax);
        }

        //Filtre sur ancienneté (année)


        if (!empty($yearMin) && $yearMin != null && !empty($yearMax) && $yearMax != null) {
            $query->andWhere('year(v.date_mise_en_circulation) >= :yearMin and year(v.date_mise_en_circulation) <= :yearMax')
                ->setParameter(':yearMin', $yearMin)
                ->setParameter(':yearMax', $yearMax);

            // dd($query->getQuery()->getResult());
        }

        //Logique classement OrderBy sur formulaire     

        if (!empty($classerPar)) {
            switch ($classerPar) {
                case "Mes favoris":
                    //Filtre sur favoris de l'utilisateur actuel 
                    if ($user) {
                        $favoris = $user->getFavoris();
                        $query->andWhere('v.id IN(:favoris)')
                            ->setParameter('favoris', $favoris);
                    }
                case "Prix descendant":
                    $query->orderBy('v.prix_vente', 'desc');
                    break;
                case "Prix ascendant":
                    $query->orderBy('v.prix_vente', 'asc');
                    break;
                case "Kilométrage descendant":
                    $query->orderBy('v.kilometrage', 'desc');
                    break;
                case "Kilométrage ascendant":
                    $query->orderBy('v.kilometrage', 'asc');
                    break;
                case "Ancienneté descendante":
                    $query->orderBy('v.date_mise_en_circulation', 'desc');
                    break;
                case "Ancienneté ascendante":
                    $query->orderBy('v.date_mise_en_circulation', 'asc');
                    break;
                default:
                    return false;
            }
        }

        //Récupération du total de véhicules retourné par la requête filtrée
        // avant pagination
        $totalItems = count($query->getQuery()->getResult());

        //Pagination sur résultats 
        $query->setFirstResult(($page * $limit) - $limit)
            ->setMaxResults($limit);
        $items = $query->getQuery()->getResult();

        return new PaginationResult($items, $totalItems);
    }

    //Max prix de vente pour filtre d'intervalle
    public function getPrixMax()
    {
        $query = $this->createQueryBuilder('pm')
            ->select('MAX(pm.prix_vente)');
        return $query->getQuery()->getSingleScalarResult();
    }
    //Min prix de vente pour filtre d'intervalle
    public function getPrixMin()
    {
        $query = $this->createQueryBuilder('pm')
            ->select('MIN(pm.prix_vente)');
        return $query->getQuery()->getSingleScalarResult();
    }
    //Min kilométrage pour filtre d'intervalle
    public function getKmMin()
    {
        $query = $this->createQueryBuilder('kmm')
            ->select('MIN(kmm.kilometrage)');
        return $query->getQuery()->getSingleScalarResult();
    }
    //Max kilométrage pour filtre d'intervalle
    public function getKmMax()
    {
        $query = $this->createQueryBuilder('kmm')
            ->select('MAX(kmm.kilometrage)');
        return $query->getQuery()->getSingleScalarResult();
    }

    public function getMinYear()
    {
        $query = $this->createQueryBuilder('v')
            ->select('MIN(year(v.date_mise_en_circulation))');
        return $query->getQuery()->getSingleScalarResult();
    }
    public function getMaxYear()
    {
        $query = $this->createQueryBuilder('v')
            ->select('MAX(year(v.date_mise_en_circulation))');
        return $query->getQuery()->getSingleScalarResult();
    }

    //Total de véhicules dans la base
    public function getTotalVehicules()
    {
        $query = $this->createQueryBuilder('v')
            ->select('COUNT(v)')
            ->where('v.publication_annonce = true');
        return $query->getQuery()->getSingleScalarResult();
    }

    //Retourner les 5 premiers résultats par date de mise en vente
    public function getLastFiveVehicules()
    {
        $query = $this->createQueryBuilder('v')
            ->select('v')
            ->orderBy('v.date_mise_en_vente', 'DESC')
            ->setMaxResults(5);

        return $query->getQuery()->getResult();
    }
}
