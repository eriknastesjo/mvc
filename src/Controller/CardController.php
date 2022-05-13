<?php

namespace App\Controller;

use App\Card\CardHand;
use App\Card\PlayerDraw;
use App\Card\CardHandJoker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardController extends AbstractController
{
    /**
     * @Route("/card", name="card", methods={"GET","HEAD"})
     */
    public function card(): Response
    {
        return $this->render('card/home.html.twig');
    }

    /**
     * @Route("/card/deck", name="deck", methods={"GET","HEAD"})
     */
    public function deck(): Response
    {
        $deck = new CardHand();

        $deck->fillWithCards();
        $data = [
            'title' => 'Deck',
            'cardDeck' => $deck->getCardIllustrations()
        ];
        return $this->render('card/deck.html.twig', $data);
    }

    /**
     * @Route("/card/deck/shuffle", name="shuffled", methods={"GET","HEAD"})
     */
    public function shuffle(SessionInterface $session): Response
    {
        $playerDraw = new PlayerDraw();

        $data = [
            'title' => 'Shuffle',
            'cardDeck' => $playerDraw->getCardIllustrationsDeck()
        ];

        $session->set("playerDraw", $playerDraw);

        return $this->render('card/shuffled.html.twig', $data);
    }

    /**
     * @Route("/card/deck/draw", name="draw", methods={"GET","HEAD"})
     */
    public function draw(SessionInterface $session): Response
    {
        $playerDraw = $session->get("playerDraw") ?? new PlayerDraw();
        $session->set("playerDraw", $playerDraw);

        $data = [
            'title' => 'Draw',
            'deckNum' => $playerDraw->getNumberCardsDeck(),
            'cardHand' => $playerDraw->getCardIllustrationsPlayers()[0]
        ];
        return $this->render('card/draw.html.twig', $data);
    }

    /**
     * @Route("/card/deck/draw", name="draw-process", methods={"POST"})
     */
    public function drawProcess(SessionInterface $session): Response
    {
        $playerDraw = $session->get("playerDraw");
        $playerDraw->playersDrawCards();

        $session->set("playerDraw", $playerDraw);

        return $this->redirectToRoute('draw');
    }

    /**
     * @Route("/card/deck/draw/{numCards}", name="draw-num", methods={"GET","HEAD"})
     */
    public function drawNum(SessionInterface $session, int $numCards): Response
    {
        $playerDraw = $session->get("playerDraw");
        $playerDraw->playersDrawCards($numCards);

        $session->set("playerDraw", $playerDraw);

        return $this->redirectToRoute('draw');
    }

    /**
     * @Route("/card/deck/deal/{playerNum}/{cardNum}", name="players", methods={"GET","HEAD"})
     */
    public function players(int $playerNum, int $cardNum): Response
    {
        $playersDraw = new PlayerDraw($playerNum);
        $playersDraw->playersDrawCards($cardNum);

        $data = [
            'title' => 'Players',
            'deckNum' => $playersDraw->getNumberCardsDeck(),
            'players' => $playersDraw->getCardIllustrationsPlayers()
        ];
        return $this->render('card/players.html.twig', $data);
    }

    /**
     * @Route("/card/deck2", name="deck2", methods={"GET","HEAD"})
     */
    public function deck2(): Response
    {
        $deck = new CardHandJoker();
        $deck->fillWithCards();
        $data = [
            'title' => 'Deck',
            'cardDeck' => $deck->getCardIllustrations()
        ];
        return $this->render('card/joker.html.twig', $data);
    }
}
