<?php

/**
 * Module with CardDraw class
 */

namespace App\Card;

/**
 * Can hold several Card objects and pick cards from other Card Hand objects.
 */
class PlayerDraw
{
    protected $deck;
    protected $players = [];

    public function __construct($playerNum = 1)
    {
        $this->deck = new CardHand();
        $this->deck->fillWithCards();
        $this->deck->shuffleHand();

        for ($i = 1; $i <= $playerNum; $i++) {
            $this->players[] = new CardHand();
        }
    }

    public function playersDrawCards($cardNum = 1)
    {
        foreach ($this->players as $player) {
            for ($i = 1; $i <= $cardNum; $i++) {
                $player->pickRandomCard($this->deck);
            }
        }
    }

    public function singlePlayerDrawCards($playerIndex, $cardNum = 1)
    {
        for ($i = 1; $i <= $cardNum; $i++) {
            $this->players[$playerIndex]->pickRandomCard($this->deck);
        }
    }

    public function getNumberCardsDeck(): int
    {
        return $this->deck->getNumberCards();
    }

    public function getCardIllustrationsDeck()
    {
        return $this->deck->getCardIllustrations();
    }

    public function getCardIllustrationsPlayers()
    {
        $listReturn = [];
        foreach ($this->players as $player) {
            $listReturn[] = $player->getCardIllustrations();
        }
        return $listReturn;
    }
}
