<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Card\CardHand;

class CardControllerJson extends AbstractController
{
    /**
     * @Route("/card/api/deck", name="api-deck", methods={"GET","HEAD"})
     */
    public function apiDeck(): Response
    {
        $deck = new CardHand();
        $deck->fillWithCards();

        return new JsonResponse($deck->getAllRaw());
    }
}
