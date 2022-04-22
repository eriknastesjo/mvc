<?php

/**
 * Module with CardHand class
 */

namespace App\Card;

use App\Card\Card;

/**
 * Can hold several Card objects and pick cards from other Card Hand objects.
 */
class CardHand
{
    protected $hand = [];
    protected array $possibleColors = array("heart","clove","diamond","spade");
    protected array $possibleValues = array(
        2 => '2',
        3 => '3',
        4 => '4',
        5 => '5',
        6 => '6',
        7 => '7',
        8 => '8',
        9 => '9',
        10 => '10',
        11 => 'Kn',
        12 => 'Q',
        13 => 'K',
        14 => 'E');


    /**
     * Pick random card(s) from other another Card Hand object.
     */
    public function pickRandomCard(CardHand $fromHand, int $numCards = 1): void
    {
        for ($i = 1; $i <= $numCards; $i++) {
            $newCard = $fromHand->discardRandomCard();
            if ($newCard != null) {
                $this->hand[] = $newCard;
            }
        }
    }

    /**
     * Discard a random card from the hand. If exists, returns the discarded card object.
     */
    public function discardRandomCard(): Card | null
    {
        if ($this->hand) {
            $key = rand(0, Count($this->hand) - 1);
            $copiedCard = $this->hand[$key];
            unset($this->hand[$key]);
            $this->hand = array_values($this->hand);    // to resetting key index!
            return $copiedCard;
        }
        return null;
    }

    /**
     * Fill hand with the typical deck cards.
     */
    public function fillWithCards(): void
    {
        foreach ($this->possibleColors as $col) {
            foreach ($this->possibleValues as $realValue => $strValue) {
                $newCard = new Card($col, $strValue, $realValue);
                $this->hand[] = $newCard;
            }
        }
    }

    /**
     * The cards in the hand are arranged in a random order.
     */
    public function shuffleHand(): void
    {
        shuffle($this->hand);
    }

    /**
     * Returns an array of the cards in viewable string format.
     */
    public function viewHand(): array
    {
        $listReturn = [];
        foreach ($this->hand as $card) {
            $listReturn[] = $card->viewCard();
        }
        return $listReturn;
    }

    /**
     * Returns the total real value of the cards.
     */
    public function getValueCards(): int
    {
        $val = 0;
        foreach ($this->hand as $card) {
            $val += $card->getValue();
        }
        return $val;
    }

    /**
     * Returns the number of cards in the hand.
     */
    public function getNumberCards(): int
    {
        return Count($this->hand);
    }

    /**
     * Returns an array of the cards in "raw" format.
     */
    public function getAllRaw(): array
    {
        $listReturn = [];
        foreach ($this->hand as $card) {
            $listReturn[] = $card->getCardRaw();
        }
        return $listReturn;
    }
}
