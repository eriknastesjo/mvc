<?php

namespace App\Controller;

use App\Card\CardHand21;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GameController extends AbstractController
{
    /**
     * @Route("/game", name="game", methods={"GET","HEAD"})
     * Homing page. Explains the rules of game 21.
     */
    public function game(SessionInterface $session): Response
    {
        $this->resetGame($session);
        return $this->render('game/home.html.twig');
    }

    /**
     * @Route("/game/session", name="game-session", methods={"GET","HEAD"})
     * Game session where you play game 21. Functions as a director depending on cards and player decisions.
     */
    public function gameSession(SessionInterface $session): Response
    {
        // $this->resetGameProcess($session);

        $deck       = $this->deckAssignment($session);
        $player     = $session->get("player21") ?? new \App\Card\CardHand21();
        $bank       = $session->get("bank21") ?? new \App\Card\CardHand21();
        $isFinished = $session->get("isFinished") ?? false;

        if ($isFinished) {
            $data = $this->getFinishData($player, $bank);
            return $this->render('game/session-finished.html.twig', $data);
        } else {
            if ($player->getNumberCards() === 0) {
                $player->pickRandomCard($deck, 2);
            }
            $data = $this->getDrawData($player, $deck);
            if ($player->getOptimalValueCards() > 21) {
                $session->set("isFinished", true);
                return $this->redirectToRoute('game-session');
            }
            return $this->render('game/session-player.html.twig', $data);
        }
    }

    /**
     * Method to assign a deck in session
     */
    private function deckAssignment(SessionInterface $session)
    {
        $deck = $session->get("deck21") ?? new \App\Card\CardHand21();
        if ($deck->getNumberCards() === 0) {
            $deck->fillWithCards();
        }
        // $session->set("deck21", $deck);
        return $deck;
    }

    /**
     * Method to get correct data when finished game
     */
    private function getFinishData(CardHand21 $player, CardHand21 $bank)
    {
        $data = [
            'title' => 'Games session',
            'player' => $player->viewHand(),
            'playerPoints' => $player->getOptimalValueCards(),
            'bank' => $bank->viewHand(),
            'bankPoints' => $bank->getValueCards()
        ];
        if ($bank->getValueCards() <= 21) {
            if ($player->getOptimalValueCards() > 21 || $player->getOptimalValueCards() <= $bank->getValueCards()) {
                $data['message'] = 'You lost!';
            } else {
                $data['message'] = 'You won!';
            }
        } else {
            $data['message'] = 'You won!';
        }
        return $data;
    }

    /**
     * Method to get correct draw data during session
     */
    private function getDrawData(CardHand21 $player, CardHand21 $deck)
    {
        $data = [
            'title' => 'Games session',
            'player' => $player->viewHand(),
            'playerMaxPoints' => $player->getValueCards(),
            'playerMinPoints' => $player->getValueCardsMin()
        ];
        // $session->set("player21", $player);
        // $session->set("deck21", $deck);
        return $data;
    }

    /**
     * @Route("/game/session/draw", name="game-session-draw", methods={"POST"})
     * Process page where player picks a card. Redirects to game session page.
     */
    public function drawProcess(SessionInterface $session)
    {
        $deck = $session->get("deck21");
        $player = $session->get("player21");
        $player->pickRandomCard($deck, 1);
        return $this->redirectToRoute('game-session');
    }

    /**
     * @Route("/game/session/finish", name="game-session-finish", methods={"POST"})
     * Process page where bank draws cards and the game ends. Redirects to game session page.
     */
    public function finishProcess(SessionInterface $session)
    {
        $session->set("isFinished", true);
        $deck = $session->get("deck21");
        $bank = $session->get("bank21");
        while ($bank->getValueCards() < 17) {
            $bank->pickRandomCard($deck, 1);
        }
        // $session->set("bank21", $bank);
        // $session->set("deck21", $deck);
        return $this->redirectToRoute('game-session');
    }

    /**
     * @Route("/game/session/reset", name="game-session-reset", methods={"POST"})
     * Process page where the game is reset. Redirects to game session page.
     */
    public function resetGameProcess(SessionInterface $session)
    {
        $this->resetGame($session);
        return $this->redirectToRoute('game-session');
    }

    /**
     * Method to reset game by creating new deck, player and bank.
     */
    private function resetGame(SessionInterface $session)
    {
        $session->set("deck21", new \App\Card\CardHand21());
        $session->set("player21", new \App\Card\CardHand21());
        $session->set("bank21", new \App\Card\CardHand21());
        $session->set("isFinished", false);
        $session->set("newGame", true);
    }

    /**
     * @Route("/game/doc", name="game-dock", methods={"GET","HEAD"})
     * Page with documentation containing flow diagram and such things.
     */
    public function gameDoc(): Response
    {
        return $this->render('game/doc.html.twig');
    }
}
