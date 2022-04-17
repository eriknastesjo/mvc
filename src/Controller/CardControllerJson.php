<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardControllerJson extends AbstractController
{
    /**
     * @Route("/card/api/deck", name="api-deck", methods={"GET","HEAD"})
     */
    public function apiDeck(): Response
    {
        $deck = new \App\Card\CardHand();
        $deck->fillWithCards();
        // $data = [
        //     'title' => 'Deck',
        //     'cardDeck' => $deck->getAllRaw()
        // ];
        return new JsonResponse($deck->getAllRaw());
    }
}
