<?php

/**
 * Module with GardenSalesRepository class.
 */

namespace App\Repository;

use App\Entity\GardenSales;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Can add or remove from table GardenSales.
 *
 * @extends ServiceEntityRepository<GardenSales>
 *
 * @method GardenSales|null find($id, $lockMode = null, $lockVersion = null)
 * @method GardenSales|null findOneBy(array $criteria, array $orderBy = null)
 * @method GardenSales[]    findAll()
 * @method GardenSales[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GardenSalesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GardenSales::class);
    }

    /**
     * Adds data to table GardenSales.
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(GardenSales $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Removes data from table GardenSales.
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(GardenSales $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    /**
     * Returns joined data from table GardenPlantedSeeds and GardenSales.
     */
    public function joinedTables(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p, s
            FROM App\Entity\GardenSales s
                INNER JOIN App\Entity\GardenPlantedSeeds p
                    WHERE s.id = p.id'
        );

        // Elements with even index will be sold plants and odd once will be planted seeds.
        $result = $query->getArrayResult();

        // Here we pair every two elements into one element.
        $listReturn = [];

        for ($i = 0; $i < count($result); $i++) {
            if ($i % 2 === 0) {
                $row = array(
                    "id" => $result[$i]['id'],
                    "plant" => $result[$i]['plant'],
                    "datePlanted" => $result[$i + 1]['date'],
                    "timePlanted" => $result[$i + 1]['time'],
                    "dateSold" => $result[$i]['date'],
                    "timeSold" => $result[$i]['time']
                );
                $listReturn[] = $row;
            }
        }

        return $listReturn;
    }

    // /**
    //  * @return GardenSales[] Returns an array of GardenSales objects
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
    public function findOneBySomeField($value): ?GardenSales
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
