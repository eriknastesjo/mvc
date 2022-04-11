<?php

namespace App\Card;

use App\Card\Card;

class CardHand
{
    protected $hand = [];
    protected array $possibleColors = array("heart","clove","diamond","spade");
    protected array $possibleValues = array(2 => '2', 3 => '3', 4 => '4', 5 => '5', 6 => '6', 7 => '7', 8 => '8', 9 => '9',10 => '10', 11 => 'Kn', 12 => 'Q', 13 => 'K', 14 => 'E');


    public function __construct(bool $drawDeck = false)
    {
        if ($drawDeck) {
            $this->drawAll();
        }
    }

    public function stealRandomCard(CardHand $fromHand): void
    {
        $newCard = $fromHand->discardRandomCard();
        if ($newCard) {
            $this->hand[] = $newCard;
        }
    }

    public function discardRandomCard(): Card
    {
        if ($this->hand) {
            $key = rand(0, Count($this->hand) - 1);
            $copiedCard = $this->hand[$key];
            unset($this->hand[$key]);
            $this->hand = array_values($this->hand);    // to resetting key index!
            return $copiedCard;
        }
    }

    public function drawAll(): void
    {
        foreach ($this->possibleColors as $col) {
            foreach ($this->possibleValues as $realValue => $strValue) {
                $newCard = new Card($col, $strValue, $realValue);
                $this->hand[] = $newCard;
            }
        }
    }

    public function shuffleHand(): void
    {
        shuffle($this->hand);
    }

    public function viewHand(): array
    {
        $listReturn = [];
        foreach ($this->hand as $card) {
            $listReturn[] = $card->viewCard();
        }
        return $listReturn;
    }

    public function getNumberCards(): int
    {
        return Count($this->hand);
    }

    public function debugPrintHand(): void
    {
        foreach ($this->hand as $card) {
            echo($card->viewCard());
        }
    }

    public function getAllRaw(): array {
        $listReturn = [];
        foreach ($this->hand as $card) {
            $listReturn[] = $card->getCardRaw();
        }
        return $listReturn;
    }

    // public function getDeck(): array {
    //     $listReturn = [];
    //     foreach ($this->possibleColors as $col) {
    //         foreach ($this->possibleValues as $key=>$val) {
    //             $newCard = new Card($col, $val, $key);
    //             $listReturn[] = $newCard->viewCard();
    //         }
    //     }
    //     return $listReturn;
    // }

    // public function getShuffledDeck(): array {
    //     $listReturn = $this->getDeck();
    //     shuffle($listReturn);
    //     return $listReturn;
    // }
}
