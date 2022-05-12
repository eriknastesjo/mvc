<?php

namespace App\Repository;

use App\Entity\GardenPlantedSeeds;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GardenPlantedSeeds>
 *
 * @method GardenPlantedSeeds|null find($id, $lockMode = null, $lockVersion = null)
 * @method GardenPlantedSeeds|null findOneBy(array $criteria, array $orderBy = null)
 * @method GardenPlantedSeeds[]    findAll()
 * @method GardenPlantedSeeds[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GardenPlantedSeedsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GardenPlantedSeeds::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(GardenPlantedSeeds $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(GardenPlantedSeeds $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return GardenPlantedSeeds[] Returns an array of GardenPlantedSeeds objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GardenPlantedSeeds
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
