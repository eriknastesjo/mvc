<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardController extends AbstractController
{
    /**
     * @Route("/card", name="card", methods={"GET","HEAD"})
     */
    public function card(): Response
    {
        $data = [
            'title' => 'Home',
            'cardHand' => "no cards yet"
        ];
        return $this->render('card/home.html.twig', $data);
    }

    /**
     * @Route("/card/deck", name="deck", methods={"GET","HEAD"})
     */
    public function deck(): Response
    {
        $deck = new \App\Card\CardHand(true);
        $data = [
            'title' => 'Deck',
            'cardDeck' => $deck->viewHand()
        ];
        return $this->render('card/deck.html.twig', $data);
    }

    /**
     * @Route("/card/deck/shuffle", name="shuffled", methods={"GET","HEAD"})
     */
    public function shuffle(SessionInterface $session): Response
    {
        $deck = new \App\Card\CardHand(true);
        $deck->shuffleHand();
        $data = [
            'title' => 'Shuffle',
            'cardDeck' => $deck->viewHand()
        ];
        $session->set("deck", new \App\Card\CardHand(true));
        $session->set("hand", new \App\Card\CardHand());
        return $this->render('card/shuffled.html.twig', $data);
    }

    /**
     * @Route("/card/deck/draw", name="draw", methods={"GET","HEAD"})
     */
    public function draw(SessionInterface $session): Response
    {
        $deck = $session->get("deck") ?? new \App\Card\CardHand(true);
        $cardHand = $session->get("hand") ?? new \App\Card\CardHand();

        $data = [
            'title' => 'Draw',
            'deckNum' => $deck->getNumberCards(),
            'cardHand' => $cardHand->viewHand()
        ];
        return $this->render('card/draw.html.twig', $data);
    }

    /**
     * @Route("/card/deck/draw", name="draw-process", methods={"POST"})
     */
    public function drawProcess(SessionInterface $session): Response
    {
        $deck = $session->get("deck") ?? new \App\Card\CardHand(true);
        $cardHand = $session->get("hand") ?? new \App\Card\CardHand();

        if ($deck->getNumberCards() > 0) {
            $cardHand->stealRandomCard($deck);
        }

        $session->set("deck", $deck);
        $session->set("hand", $cardHand);

        return $this->redirectToRoute('draw');
    }

    /**
     * @Route("/card/deck/draw/{numCards}", name="draw-num", methods={"GET","HEAD"})
     */
    public function drawNum(SessionInterface $session, int $numCards): Response
    {
        $deck = $session->get("deck") ?? new \App\Card\CardHand(true);
        $cardHand = $session->get("hand") ?? new \App\Card\CardHand();

        for ($i = 1; $i <= $numCards; $i++) {
            if ($deck->getNumberCards() > 0) {
                $cardHand->stealRandomCard($deck);
            }
        }

        $session->set("deck", $deck);
        $session->set("hand", $cardHand);

        return $this->redirectToRoute('draw');
    }

    /**
     * @Route("/card/deck/deal/{playerNum}/{cardNum}", name="players", methods={"GET","HEAD"})
     */
    public function players(SessionInterface $session, int $playerNum, int $cardNum): Response
    {
        $deck = new \App\Card\CardHand(true);
        // obs, när göra om till session, ha annat
        // variabelnamn än "deck" så det inte krockar med ovan!!
        $players = [];
        $playersViewCards = [];
        for ($i = 1; $i <= $playerNum; $i++) {
            $players[] = new \App\Card\CardHand();
        }
        foreach ($players as $player) {
            for ($i = 1; $i <= $cardNum; $i++) {
                $player->stealRandomCard($deck);
            }
        }
        foreach ($players as $player) {
            $playersViewCards[] = $player->viewHand();
        }
        $data = [
            'title' => 'Players',
            'deckNum' => $deck->getNumberCards(),
            'players' => $playersViewCards
        ];
        return $this->render('card/players.html.twig', $data);
    }

    /**
     * @Route("/card/deck2", name="deck2", methods={"GET","HEAD"})
     */
    public function deck2(): Response
    {
        $deck = new \App\Card\CardHandJoker(true);
        $data = [
            'title' => 'Deck',
            'cardDeck' => $deck->viewHand()
        ];
        return $this->render('card/joker.html.twig', $data);
    }
}
