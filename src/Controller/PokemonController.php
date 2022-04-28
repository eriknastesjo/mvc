<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Pokemon;
use App\Repository\PokemonRepository;
use Doctrine\Persistence\ManagerRegistry;


class PokemonController extends AbstractController
{
    #[Route('/pokedex', name: 'app_pokemon')]
    public function index(): Response
    {
        return $this->render('pokemon/index.html.twig', [
            'controller_name' => 'PokemonController',
        ]);
    }

    /**
     * @Route("/pokedex/catch", name="catch"), methods={"GET","HEAD"})
     */
    public function catchPokemon(): Response {
        return $this->render('pokemon/catch.html.twig');
    }

    /**
     * @Route("/pokedex/catch/process", name="catch-process", methods={"POST"}))
     */
    public function catchPokemonProcess(
        ManagerRegistry $doctrine,
        Request $request
    ): Response {
        $entityManager = $doctrine->getManager();

        $pokemon = new Pokemon();
        $pokemon->setName($request->request->get('name'));
        $pokemon->setType($request->request->get('type'));
        $pokemon->setAttack($request->request->get('attack'));
        $pokemon->setHp($request->request->get('hp'));
        $pokemon->setDescription($request->request->get('description'));

        // tell Doctrine you want to (eventually) save the Pokemon
        // (no queries yet)
        $entityManager->persist($pokemon);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->redirectToRoute('catch');   // change later to show details of added pokemon
    }

    /**
     * @Route("/pokedex/observe", name="observe"), methods={"GET","HEAD"})
     */
    public function observePokemon(
        PokemonRepository $pokemonRepository
    ): Response {
        $allPokemon = $pokemonRepository->findAll();

        $data = [
            'allPokemon' => $allPokemon
        ];

        return $this->render('pokemon/observe.html.twig', $data);
    }
}
