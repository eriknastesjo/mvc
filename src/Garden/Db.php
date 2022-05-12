<?php

namespace App\Controller;

use DateTime;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\GardenPlant;
use App\Entity\GardenSales;
use App\Repository\GardenSaleRepository;
use App\Repository\GardenPlantRepository;
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

        $gardenPlant = new GardenPlant();
        $gardenPlant->setPlant($plant->getName());
        $gardenPlant->setDate($currentDate->format('y-m-d'));
        $gardenPlant->setTime($currentDate->format('H:i'));

        // tell Doctrine you want to (eventually) save the plant
        // (no queries yet)
        $entityManager->persist($gardenPlant);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $gardenPlant;      // in method that called -> use $plant->getId() to get Id
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
}
