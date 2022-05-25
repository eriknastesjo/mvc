<?php

/**
 * Module with Database class.
 */

namespace App\Garden;

use DateTime;
use App\Entity\GardenPlantedSeeds;
use App\Entity\GardenSales;
use App\Entity\User;
use App\Repository\GardenPlantedSeedsRepository;
use App\Repository\GardenSalesRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Garden\Plant;

/**
 * Holds methods to set and get data from Garden tables.
 */
class Database
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
     * Returns an unique acronym name that is not already in database
     */
    public function newAcronymToDB(
        UserRepository $userRep,
        String $acronymName
    ): String {

        $allUsers = $userRep->findAll();

        $num = 1;

        foreach ($allUsers as $user) {
            if ($user->getAcronym() === $acronymName) {
                $num++;
            }
        }

        if ($num > 1) {
            return $acronymName . $num;
        }
        return $acronymName;
    }

    /**
     * Checks if acronym and password is correct.
     * Will return id if true otherwise false.
     */
    public function getIdThroughAcrAndPassw(
        UserRepository $userRep,
        String $acronymName,
        String $password
    ): Mixed {

        $allUsers = $userRep->findAll();

        foreach ($allUsers as $user) {
            if ($user->getAcronym() === $acronymName && $user->getPassword() === $password) {
                return $user->getId();
            }
        }
        return false;
    }

    /**
     * Adds a new row to the table User. Return the entity of the row.
     */
    public function addToTableUser(
        ManagerRegistry $doctrine,
        String $acronymName,
        String $password,
        String $firstName,
        String $lastName,
    ): User {
        $entityManager = $doctrine->getManager();

        // check first how many of the same acronym there is

        $newUser = new User();
        $newUser->setAcronym($acronymName);
        $newUser->setPassword($password);
        $newUser->setFirstName($firstName);
        $newUser->setLastName($lastName);
        $newUser->setImgURL("https://images.pexels.com/photos/1072824/pexels-photo-1072824.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2");
        $newUser->setStatus("user");


        // tell Doctrine you want to (eventually) save the sale
        // (no queries yet)
        $entityManager->persist($newUser);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $newUser;
    }

    /**
     * Get row through id from the table User
     */
    public function getRowByIdTableUser(UserRepository $userRep, int $id): User
    {
        return $userRep->findOneById($id);
    }

    /**
     * Update row by id in table User
     */
    public function updateUserInfo(
        ManagerRegistry $doctrine,
        UserRepository $userRep,
        int $id,
        string $description,
        string $imgURL): User
    {
        $entityManager = $doctrine->getManager();

        $rowToUpdate = $this->getRowByIdTableUser($userRep, $id);

        $rowToUpdate->setDescription($description);
        $rowToUpdate->setImgURL($imgURL);

        // tell Doctrine you want to (eventually) save the plant
        // (no queries yet)
        $entityManager->persist($rowToUpdate);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $rowToUpdate;

        // $updateInfo = new User();
        // $updateInfo->setId($id);
        // $updateInfo->setDescription($description);

        // $entityManager->merge($updateInfo);
        // $entityManager->flush();
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

    /**
     * Returns joined data from table GardenPlantedSeeds and GardenSales.
     */
    public function joinedTables(GardenSalesRepository $gardenSalesRep): array {
        return $gardenSalesRep->joinedTables();
    }

}
