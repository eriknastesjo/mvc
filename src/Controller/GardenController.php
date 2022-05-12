<?php

namespace App\Controller;

use DateTime;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\GardenPlant;
use App\Entity\GardenSales;
use App\Repository\GardenSaleRepository;
use App\Repository\GardenPlantRepository;
use Doctrine\Persistence\ManagerRegistry;

use App\Garden\SeedBox;
use App\Garden\Garden;
use App\Garden\Customer;
use App\Garden\Plant;

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

        $dB = new Db();
        $plantDb = $dB->addToTablePlant($doctrine, $newPlant);

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


    // /**
    //  */
    // private function addToTablePlant(
    //     ManagerRegistry $doctrine,
    //     Plant $plant
    // ) {

    //     $entityManager = $doctrine->getManager();

    //     $currentDate = new DateTime();

    //     $gardenPlant = new GardenPlant();
    //     $gardenPlant->setPlant($plant->getName());
    //     $gardenPlant->setDate($currentDate->format('y-m-d'));
    //     $gardenPlant->setTime($currentDate->format('H:i'));

    //     // tell Doctrine you want to (eventually) save the plant
    //     // (no queries yet)
    //     $entityManager->persist($gardenPlant);

    //     // actually executes the queries (i.e. the INSERT query)
    //     $entityManager->flush();

    //     return $gardenPlant;      // in method that called -> use $plant->getId() to get Id
    // }

    // /**
    //  */
    // private function addToTableSale(
    //     ManagerRegistry $doctrine,
    //     Plant $plant
    // ) {

    //     $entityManager = $doctrine->getManager();

    //     $currentDate = new DateTime();

    //     $gardenSale = new GardenSales();
    //     $gardenSale->setId($plant->getId());
    //     $gardenSale->setPlant($plant->getName());
    //     $gardenSale->setPrice($plant->getPrice());
    //     $gardenSale->setDate($currentDate->format('y-m-d'));
    //     $gardenSale->setTime($currentDate->format('H:i'));

    //     // tell Doctrine you want to (eventually) save the sale
    //     // (no queries yet)
    //     $entityManager->persist($gardenSale);

    //     // actually executes the queries (i.e. the INSERT query)
    //     $entityManager->flush();

    //     // return $this->redirectToRoute('garden');
    // }


}
