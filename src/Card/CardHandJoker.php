<?php

namespace App\Card;

use App\Card\Card;

// use App\Card\CardHand;

class CardHandJoker extends CardHand
{
    private int $jokerNum = 2;

    public function fillWithCards(): void
    {
        foreach ($this->possibleColors as $col) {
            foreach ($this->possibleValues as $key => $val) {
                $newCard = new Card($col, $val, $key);
                $this->hand[] = $newCard;
            }
        }
        for ($i = 1; $i <= $this->jokerNum; $i++) {
            $this->hand[] = new Card('joker', '', 15);
        }
    }
}
