<?php

/**
 * Module with GardenController class.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\GardenPlantedSeedsRepository;
use App\Repository\GardenSalesRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Garden\ConvertStrings;

use App\Garden\SeedBox;
use App\Garden\Garden;
use App\Garden\Customer;
use App\Garden\Database;

/**
 * Controls the routes of Garden pages.
 */
class GardenController extends AbstractController
{
    /**
     * Renders landing page.
     * @Route("/proj", name="garden-home", methods={"GET","HEAD"})
     */
    public function gardenHome(UserRepository $userRep, SessionInterface $session): Response
    {
        $userId = $session->get("userId");

        $data = [
            'userId' => null,
            'acronym' => null,
            'fName' => null,
            'lName' => null,
            'imgURL' => null,
            'description' => null,
            'status' => null
        ];

        // find row info from table User
        if ($userId) {
            $db = new Database;
            $row = $db->getRowByIdTableUser($userRep, $userId);
            $data = [
                'userId' => $userId,
                'acronym' => $row->getAcronym(),
                'fName' => $row->getFirstName(),
                'lName' => $row->getLastName(),
                'imgURL' => $row->getImgURL(),
                'description' => $row->getDescription(),
                'status' => $row->getStatus()
            ];
        }

        return $this->render('garden/home.html.twig', $data);
    }

    /**
     * Renders garden page with Garden object and SeedBox object.
     * @Route("/proj/garden", name="garden", methods={"GET","HEAD"})
     */
    public function garden(SessionInterface $session): Response
    {
        $garden = $session->get("garden") ?? new Garden(3);

        foreach ($garden->getAllPlants() as $plant) {
            $plant->checkIfDestroyedOrPuddle();
        }

        $seedBox = new SeedBox();

        $data = [
            'garden' => $garden->getAllPlants(),
            'seedBox' => $seedBox->getSeedBox()
        ];

        $session->set("garden", $garden);
        return $this->render('garden/garden.html.twig', $data);
    }

    /**
     * Processing page, adding a plant to Garden object and to database table.
     * @Route("/proj/add", name="add-process", methods={"POST"})
     */
    public function addProcess(
        ManagerRegistry $doctrine,
        Request $request,
        SessionInterface $session
    ) {
        $name = $request->get('name');
        $price = $request->get('price');
        $index = $request->get('index');

        $garden = $session->get("garden") ?? new Garden(3);
        $garden->plantSeed($name, $price, $index);

        $newPlant = $garden->getPlant($index);

        $db = new Database();
        $plantDb = $db->addToTablePlant($doctrine, $newPlant);

        $newPlant->setId($plantDb->getId());

        $session->set("garden", $garden);
        return $this->redirectToRoute('garden');
    }

    /**
     * Processing page, increasing growth level by 1 for a plant.
     * @Route("/proj/incrementGrowth", name="increment-growth", methods={"POST"})
     */
    public function incrementGrowth(Request $request, SessionInterface $session)
    {
        $garden = $session->get("garden") ?? new Garden(3);
        $garden->waterPlant($request->get('index'));

        $session->set("garden", $garden);
        return $this->redirectToRoute('garden');
    }

    /**
     * Renders customer page, checking if order matches plants in garden.
     * @Route("/proj/customer", name="garden-customer", methods={"GET","HEAD"})
     */
    public function customer(SessionInterface $session, ManagerRegistry $doctrine): Response
    {
        $newIncome = null;

        $seedBox = new SeedBox();
        $garden = $session->get("garden") ?? new Garden(3);

        $customer = $session->get("customer") ?? new Customer($seedBox->getSeedNames());

        $isMatched = $customer->matchOrder($garden->getAllPlants());

        if ($isMatched) {
            $newIncome = $garden->sellAll();
            $database = new Database();
            foreach ($garden->getAllPlants() as $plant) {
                $database->addToTableSale($doctrine, $plant);
            }
            $garden->reset(3);
        };

        $data = [
            'message' => $customer->getOrderMessage(),
            'newIncome' => $newIncome,
            'numberSold' => $garden->getNumberSold(),
            'totalIncome' => $garden->getTotalIncome()
        ];

        if ($isMatched) {
            $customer = null;
        };

        $session->set("garden", $garden);
        $session->set("customer", $customer);
        return $this->render('garden/customer.html.twig', $data);
    }


    /**
     * Renders history with rows from database tables.
     * @Route("/proj/history", name="garden-history", methods={"GET","HEAD"})
     */
    public function history(
        GardenPlantedSeedsRepository $gardenPlantRep,
        GardenSalesRepository $gardenSalesRep
    ): Response {
        $db = new Database();

        $tablePlantedSeeds = $db->getTableGardenPlant($gardenPlantRep);
        $tableSales = $db->getTableGardenSales($gardenSalesRep);
        $tableJoined = $db->joinedTables($gardenSalesRep);

        $data = [
            'tablePlantedSeeds' => $tablePlantedSeeds,
            'tableSales' => $tableSales,
            'tableJoined' => $tableJoined
        ];

        return $this->render('garden/history.html.twig', $data);
    }

    /**
     * Resets database tables and Garden object, redirects to garden page.
     * @Route("/proj/reset", name="garden-reset", methods={"GET","HEAD"})
     */
    public function reset(
        ManagerRegistry $doctrine,
        SessionInterface $session
    ): Response {
        $db = new Database();

        $db->resetTableGardenPlantedSeeds($doctrine);
        $db->resetTableGardenSales($doctrine);

        $session->set("garden", new Garden(3));

        return $this->redirectToRoute('garden');
    }

    /**
     * Renders about page.
     * @Route("/proj/about", name="garden-about", methods={"GET","HEAD"})
     */
    public function about(): Response
    {
        return $this->render('garden/about.html.twig');
    }
}
