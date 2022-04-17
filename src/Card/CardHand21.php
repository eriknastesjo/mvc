<?php

namespace App\Card;

use App\Card\Card;

// use App\Card\CardHand;

class CardHand21 extends CardHand
{
    public function getValueCardsMin(): int
    {
        $val = 0;
        foreach ($this->hand as $card) {
            if ($card->getValue() === 14) {
                $val += 1;
            } else {
                $val += $card->getValue();
            }
        }
        return $val;
    }

    public function getOptimalValueCards(): int
    {
        $valMin = $this->getValueCardsMin();
        $valMax = $this->getValueCards();
        if ($valMax <= 21) {
            return $valMax;
        }
        return $valMin;
    }
}
