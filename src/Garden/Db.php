<?php

namespace App\Controller;

use DateTime;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\GardenPlantedSeeds;
use App\Entity\GardenSales;

use App\Repository\GardenPlantedSeedsRepository;
use App\Repository\GardenSalesRepository;

use Doctrine\Persistence\ManagerRegistry;

use App\Garden\Plant;


class Db extends AbstractController
{

    /**
     */
    public function addToTablePlant(
        ManagerRegistry $doctrine,
        Plant $plant
    ) {

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

        return $gardenPlantedSeed;      // in method that called -> use $plant->getId() to get Id
    }

    /**
     */
    public function addToTableSale(
        ManagerRegistry $doctrine,
        Plant $plant
    ) {

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

        // return $this->redirectToRoute('garden');
    }

    /**
     */
    public function getTableGardenPlant(GardenPlantedSeedsRepository $gardenPlantRepository)
    {
        return $gardenPlantRepository->findAll();
    }

    /**
     */
    public function getTableGardenSales(GardenSalesRepository $gardenSalesRepository)
    {
        return $gardenSalesRepository->findAll();
    }

}
