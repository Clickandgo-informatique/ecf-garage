<?php

namespace App\Repository;

use App\Entity\Creneaux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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

    //    /**
    //     * @return Creneaux[] Returns an array of Creneaux objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Creneaux
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
