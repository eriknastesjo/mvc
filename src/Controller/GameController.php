<?php

namespace App\Controller;

use App\Card\Player21;
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
    public function game(): Response
    {
        return $this->render('game/home.html.twig');
    }

    /**
     * @Route("/game/session", name="game-session", methods={"GET","HEAD"})
     * Game session where you play game 21. Functions as a director depending on cards and player decisions.
     */
    public function gameSession(SessionInterface $session): Response
    {
        $game = $session->get("game") ?? new Player21();
        $session->set("game", $game);

        if ($game->isFinished()) {
            return $this->render('game/session-finished.html.twig', $game->getEndData());
        } else {
            $data = $game->getCurrentData();
            return $this->render('game/session-player.html.twig', $data);
        }
    }

    /**
     * @Route("/game/session/draw", name="game-session-draw", methods={"POST"})
     * Process page where player picks a card. Redirects to game session page.
     */
    public function drawProcess(SessionInterface $session)
    {
        $game = $session->get("game");
        $game->playerDrawCard();

        return $this->redirectToRoute('game-session');
    }

    /**
     * @Route("/game/session/finish", name="game-session-finish", methods={"POST"})
     * Process page where bank draws cards and the game ends. Redirects to game session page.
     */
    public function finishProcess(SessionInterface $session)
    {
        $game = $session->get("game");
        $game->setIsFinished(true);

        return $this->redirectToRoute('game-session');
    }

    /**
     * @Route("/game/session/reset", name="game-session-reset", methods={"POST"})
     * Process page where the game is reset. Redirects to game session page.
     */
    public function resetGameProcess(SessionInterface $session)
    {
        $game = new Player21();
        $session->set("game", $game);
        return $this->redirectToRoute('game-session');
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
