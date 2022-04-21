<?php

namespace App\Card;

use App\Card\Card;

// use App\Card\CardHand;

class CardHand21 extends CardHand
{

    /**
     * Returns the total real value of the cards, counting the ace as value 1.
     */
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

    /**
     * Returns the total real value of the cards. Counting the ace as value 14 if total value is below 21, otherwise ace counts as 1.
     */
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
