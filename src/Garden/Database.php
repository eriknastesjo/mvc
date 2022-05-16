<?php

/**
 * Module with Database class.
 */

namespace App\Garden;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\GardenPlantedSeeds;
use App\Entity\GardenSales;
use App\Repository\GardenPlantedSeedsRepository;
use App\Repository\GardenSalesRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Garden\Plant;


/**
 * Holds methods to set and get data from Garden tables.
 */
class Database extends AbstractController
{

    /**
     * Adds a new row to the table GardenPlantedSeeds. Return the entity of the row.
     */
    public function addToTablePlant(
        ManagerRegistry $doctrine,
        Plant $plant
    ): GardenPlantedSeeds {

        $entityManager = $doctrine->getManager();

        $currentDate = new DateTime();

        $gardenPlantedSeed = new GardenPlantedSeeds();
        $gardenPlantedSeed->setPlant($plant->getName());
        $gardenPlantedSeed->setDate($currentDate->format('y-m-d'));
        $gardenPlantedSeed->setTime($currentDate->format('H:i'));

        // tell Doctrine you want to (eventually) save the plant
        // (no queries yet)
        $entityManager->persist($gardenPlantedSeed);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $gardenPlantedSeed;
    }

    /**
     * Adds a new row to the table GardenSales. Return the entity of the row.
     */
    public function addToTableSale(
        ManagerRegistry $doctrine,
        Plant $plant
    ): GardenSales {

        $entityManager = $doctrine->getManager();

        $currentDate = new DateTime();

        $gardenSale = new GardenSales();
        $gardenSale->setId($plant->getId());
        $gardenSale->setPlant($plant->getName());
        $gardenSale->setPrice($plant->getPrice());
        $gardenSale->setDate($currentDate->format('y-m-d'));
        $gardenSale->setTime($currentDate->format('H:i'));

        // tell Doctrine you want to (eventually) save the sale
        // (no queries yet)
        $entityManager->persist($gardenSale);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $gardenSale;
    }

    /**
     * Get all rows from the table GardenPlantedSeeds
     */
    public function getTableGardenPlant(GardenPlantedSeedsRepository $gardenPlantRep): array
    {
        return $gardenPlantRep->findAll();
    }

    /**
     * Get all rows from the table GardenSales
     */
    public function getTableGardenSales(GardenSalesRepository $gardenSalesRep): array
    {
        return $gardenSalesRep->findAll();
    }

    /**
     * Deleting all rows from GardenPlantedSeeds
     */
    public function resetTableGardenPlantedSeeds(ManagerRegistry $doctrine): void
    {
        $entityManager = $doctrine->getManager();

        $gardenPlantedSeeds = $entityManager->getRepository(GardenPlantedSeeds::class)->findAll();

        foreach ($gardenPlantedSeeds as $row) {
            $entityManager->remove($row);
        }

        $entityManager->flush();
    }

    /**
     * Deleting all rows from GardenSales
     */
    public function resetTableGardenSales(ManagerRegistry $doctrine): void
    {
        $entityManager = $doctrine->getManager();

        $gardenSales = $entityManager->getRepository(GardenSales::class)->findAll();

        foreach ($gardenSales as $row) {
            $entityManager->remove($row);
        }

        $entityManager->flush();
    }
}
