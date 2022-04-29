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
    public function catchPokemon(): Response
    {
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

        return $this->redirectToRoute('pokedex');   // change later to show details of added pokemon
    }

    /**
     * @Route("/pokedex/pokedex", name="pokedex"), methods={"GET","HEAD"})
     */
    public function pokedex(PokemonRepository $pokemonRepository): Response
    {
        $allPokemon = $pokemonRepository->findAll();

        $data = [
            'allPokemon' => $allPokemon
        ];

        return $this->render('pokemon/pokedex.html.twig', $data);
    }

    /**
     * @Route("/pokedex/pokedex/{id}", name="pokedex-single"), methods={"GET","HEAD"})
     */
    public function pokedexSingle(
        PokemonRepository $pokemonRepository,
        int $id
    ): Response {
        $pokemon = $pokemonRepository->find($id);

        $data = [
            'pokemon' => $pokemon
        ];

        return $this->render('pokemon/pokedex-single.html.twig', $data);
    }

    /**
     * @Route("/pokedex/experiment/{id}", name="experiment"), methods={"GET","HEAD"})
     */
    public function experimentPokemon(
        PokemonRepository $pokemonRepository,
        int $id
    ): Response {
        $pokemon = $pokemonRepository->find($id);

        $data = [
            'pokemon' => $pokemon
        ];

        return $this->render('pokemon/experiment.html.twig', $data);
    }

    /**
     * @Route("/pokedex/experiment-process", name="experiment-process", methods={"POST"})
     */
    public function experimentProcess(
        ManagerRegistry $doctrine,
        Request $request
    ): Response {
        $entityManager = $doctrine->getManager();
        $id = $request->request->get('id');

        $pokemon = $entityManager->getRepository(Pokemon::class)->find($id);

        if (!$pokemon) {
            throw $this->createNotFoundException(
                'No pokemon found for id ' . $id
            );
        }

        $pokemon->setName($request->request->get('name'));
        $pokemon->setType($request->request->get('type'));
        $pokemon->setAttack($request->request->get('attack'));
        $pokemon->setHp($request->request->get('hp'));
        $pokemon->setDescription($request->request->get('description'));

        $entityManager->flush();

        return $this->redirectToRoute('pokedex');
    }

    /**
     * @Route("/pokedex/release/{id}", name="release"), methods={"GET","HEAD"})
     */
    public function release(
        PokemonRepository $pokemonRepository,
        int $id
    ): Response {
        $pokemon = $pokemonRepository->find($id);

        $data = [
            'pokemon' => $pokemon
        ];

        return $this->render('pokemon/release.html.twig', $data);
    }

    /**
     * @Route("/pokemon/release/process", name="release-process", methods={"POST"})
     */
    public function releasepokemonById(
        ManagerRegistry $doctrine,
        Request $request
    ): Response {
        $entityManager = $doctrine->getManager();
        $id = $request->request->get('id');

        $pokemon = $entityManager->getRepository(Pokemon::class)->find($id);

        if (!$pokemon) {
            throw $this->createNotFoundException(
                'No pokemon found for id ' . $id
            );
        }

        $entityManager->remove($pokemon);
        $entityManager->flush();

        return $this->redirectToRoute('pokedex');
    }
}
