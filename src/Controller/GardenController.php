<?php

namespace App\Controller;

use App\Card\Player21;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\Flower;
use App\Repository\FlowerRepository;
use Doctrine\Persistence\ManagerRegistry;

use App\Garden\SeedBox;
use App\Garden\Garden;

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
    public function garden(FlowerRepository $flowerRepository, SessionInterface $session): Response
    {
        // $allFlowers = $flowerRepository->findAll();
        // $garden = new Garden(3);    // uncomment to reset

        $garden = $session->get("garden") ?? new Garden(3);
        $session->set("garden", $garden);

        $seedBox = new SeedBox();

        $data = [
            'garden' => $garden->getGarden(),
            'seedBox' => $seedBox->getSeedBox()
        ];

        // var_dump($garden);

        return $this->render('garden/garden.html.twig', $data);
    }

    /**
     * @Route("/proj/add", name="add-process", methods={"POST"})
     */
    public function addProcess(Request $request, SessionInterface $session)
    {
        $garden = $session->get("garden");
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


    // /**
    //  * @Route("/proj/add", name="add-logg")
    //  */
    // private function addLog(
    //     FlowerRepository $flowerRepository,
    //     Request $request,
    //     ManagerRegistry $doctrine
    // ): Response {
    //     $entityManager = $doctrine->getManager();

    //     $flower = new Flower();
    //     // $flower->setName($request->request->get('name'));    <-- instead directly from arguments
    //     // $flower->setGrowthLevel($request->request->get('name'));    <-- instead directly from arguments


    //     // tell Doctrine you want to (eventually) save the flower
    //     // (no queries yet)
    //     $entityManager->persist($flower);

    //     // actually executes the queries (i.e. the INSERT query)
    //     $entityManager->flush();

    //     return $this->redirectToRoute('garden');
    // }


}
