<?php

namespace App\Controller;

use App\Entity\GardenPlantedSeeds;
use App\Entity\GardenSales;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Component\HttpFoundation\Request;

use App\Repository\GardenPlantedSeedsRepository;
use App\Repository\GardenSalesRepository;
use Doctrine\Persistence\ManagerRegistry;

use App\Garden\SeedBox;
use App\Garden\Garden;
use App\Garden\Customer;

class GardenController extends AbstractController
{

    /**
     * @Route("/proj", name="garden-home", methods={"GET","HEAD"})
     */
    public function gardenHome(): Response
    {
        return $this->render('garden/home.html.twig');
    }

    /**
     * @Route("/proj/garden", name="garden", methods={"GET","HEAD"})
     */
    public function garden(SessionInterface $session): Response
    {
        // $garden = new Garden(3);    // uncomment to reset

        $garden = $session->get("garden") ?? new Garden(3);

        foreach ($garden->getGarden() as $plant) {
            $plant->checkIfDestroyedOrPuddle();
        }

        $seedBox = new SeedBox();

        $data = [
            'garden' => $garden->getGarden(),
            'seedBox' => $seedBox->getSeedBox()
        ];

        // var_dump($garden);

        $session->set("garden", $garden);
        return $this->render('garden/garden.html.twig', $data);
    }

    /**
     * @Route("/proj/add", name="add-process", methods={"POST"})
     */
    public function addProcess(
        ManagerRegistry $doctrine,
        Request $request,
        SessionInterface $session)
    {
        $name = $request->get('name');
        $price = $request->get('price');
        $index = $request->get('index');

        $garden = $session->get("garden");
        $garden->plantSeed($name, $price, $index);

        $newPlant = $garden->getPlant($index);

        $db = new Db();
        $plantDb = $db->addToTablePlant($doctrine, $newPlant);

        $newPlant->setId($plantDb->getId());

        return $this->redirectToRoute('garden');
    }

    /**
     * @Route("/proj/incrementGrowth", name="increment-growth", methods={"POST"})
     */
    public function incrementGrowth(Request $request, SessionInterface $session)
    {
        $garden = $session->get("garden");
        $garden->waterPlant($request->get('index'));

        return $this->redirectToRoute('garden');
    }

    /**
     * @Route("/proj/customer", name="garden-customer", methods={"GET","HEAD"})
     */
    public function customer(SessionInterface $session, ManagerRegistry $doctrine,): Response
    {
        $newIncome = null;

        $seedBox = new SeedBox();
        $garden = $session->get("garden") ?? new Garden(3);

        $customer = $session->get("customer") ?? new Customer($seedBox->getSeedNames());

        $isMatched = $customer->matchOrder($garden->getGarden());

        if ($isMatched) {

            $newIncome = $garden->sellAll();
            $dB = new Db();
            foreach ($garden->getGarden() as $plant) {
                $dB->addToTableSale($doctrine, $plant);
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
     * @Route("/proj/history", name="garden-statistics", methods={"GET","HEAD"})
     */
    public function gardenStatistics(
        GardenPlantedSeedsRepository $gardenPlantRepository,
        GardenSalesRepository $gardenSalesRepository): Response
    {
        $db = new dB();

        $tablePlantedSeeds = $db->getTableGardenPlant($gardenPlantRepository);
        $tableSales = $db->getTableGardenSales($gardenSalesRepository);

        $data = [
            'tablePlantedSeeds' => $tablePlantedSeeds,
            'tableSales' => $tableSales
        ];



        return $this->render('garden/statistics.html.twig', $data);
    }

    /**
     * @Route("/proj/reset", name="garden-reset", methods={"GET","HEAD"})
     */
    public function gardenReset(
        ManagerRegistry $doctrine,
        SessionInterface $session
    ): Response {

        $db = new dB();

        $db->resetTableGardenPlantedSeeds($doctrine);
        $db->resetTableGardenSales($doctrine);

        $session->set("garden", new Garden(3));

        return $this->redirectToRoute('garden');
    }

}
