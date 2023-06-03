<?php

namespace App\Repository;

use App\Entity\Vehicules;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
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

    //Pagination liste véhicules
    public function findVehiculesPaginated(int $page, string $slug, int $limit = 6): array
    {
        $limit = abs($limit);
        $result = [];

        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('tv', 'v')
            ->from('App\Entity\Vehicules', 'v')
            ->join('v.type_vehicule', 'tv')
            ->where("tv.slug='$slug'")
            ->setMaxResults($limit)
            ->setFirstResult(($page*$limit)-$limit);

            $paginator=new Paginator($query);
            $data=$paginator->getQuery()->getResult();

            //Contrôle l'existence de données
            if(empty($data)){
                return $result;                
            }

     
            //Calcul du nombre de pages
            $pages=ceil($paginator->count()/$limit);

            //Remplissage du tableau
            $result['data']=$data;
            $result['pages']=$pages;
            $result['page']=$page;
            $result['limit']=$limit;


        return $result;
    }

    //    /**
    //     * @return Vehicules[] Returns an array of Vehicules objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('v.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Vehicules
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
