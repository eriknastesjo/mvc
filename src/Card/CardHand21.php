<?php

namespace App\Card;

class CardHand21 extends CardHand
{
    /**
     * Returns the total real value of the cards, counting the ace as value 1.
     */
    public function getValueCardsMin(): int
    {
        $val = 0;
        // foreach ($this->hand as $card) {
        //     if ($card->getValue() === 14) {
        //         $val += 1;
        //     } else {
        //         $val += $card->getValue();
        //     }
        // }

        foreach ($this->hand as $card) {
            $valAdd = $card->getValue() === 14 ? 1 : $card->getValue();
            $val += $valAdd;
        }
        return $val;
    }

    /**
     * Returns the best outcome value of the cards in game 21.
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
