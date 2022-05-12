<?php

namespace App\Controller;

use App\Card\Player21;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\GardenSale;
use App\Entity\GardenPlant;
use App\Repository\GardenSaleRepository;
use App\Repository\GardenPlantRepository;
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
    public function addProcess(Request $request, SessionInterface $session)
    {
        $garden = $session->get("garden");
        // $garden->plantSeed('potato', 50, 0);
        $garden->plantSeed($request->get('name'), $request->get('price'), $request->get('index'));

        return $this->redirectToRoute('garden');
    }

    /**
     * @Route("/proj/incrementGrowth", name="increment-growth", methods={"POST"})
     */
    public function incrementGrowth(Request $request, SessionInterface $session)
    {
        $garden = $session->get("garden");
        $garden->waterFlower($request->get('index'));
        // $garden->plantSeed($request->get('name'), $request->get('price'), $request->get('index'));

        return $this->redirectToRoute('garden');
    }

    /**
     * @Route("/proj/customer", name="garden-customer", methods={"GET","HEAD"})
     */
    public function customer(SessionInterface $session): Response
    {
        $newIncome = null;

        $seedBox = new SeedBox();
        $garden = $session->get("garden") ?? new Garden(3);

        $customer = $session->get("customer") ?? new Customer($seedBox->getSeedNames());

        $isMatched = $customer->matchOrder($garden->getGarden());

        if ($isMatched) {

            $newIncome = $garden->sellAll();
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
     */
    private function addPlant(
        GardenSaleRepository $gardenSaleRepository,
        ManagerRegistry $doctrine,
        array $plant,
        string $date
    ) {
        $entityManager = $doctrine->getManager();

        $plant = new GardenSale();
        $plant->setName($plant->getName());
        $plant->setDate($date);

        // tell Doctrine you want to (eventually) save the flower
        // (no queries yet)
        $entityManager->persist($plant);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $plant;      // in method that called -> use $plant->getId() to get Id

        // OBS Använd nedanstående format för att få id (som kan skickas till addSale sen)
        // $em->persist($user);
        // $em->flush();
        // $user->getId();
    }

    /**
     */
    private function addSale(
        GardenSaleRepository $gardenSaleRepository,
        ManagerRegistry $doctrine,
        array $soldPlants,
        string $date
    ) {
        $entityManager = $doctrine->getManager();

        foreach ($soldPlants as $sale) {
            $gardenSale = new GardenSale();
            $gardenSale->setName($sale->getName());
            $gardenSale->setName($sale->getName());
            $gardenSale->setPrice($sale->getPrice());
            $gardenSale->setDate($date);

            // tell Doctrine you want to (eventually) save the flower
            // (no queries yet)
            $entityManager->persist($gardenSale);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();
        }

        // return $this->redirectToRoute('garden');
    }


}
