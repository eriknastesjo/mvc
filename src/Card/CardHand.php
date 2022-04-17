<?php

namespace App\Card;

use App\Card\Card;
use Doctrine\ORM\Query\Expr\Func;

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

    public function pickRandomCard(CardHand $fromHand, int $numCards = 1): void
    {
        for ($i = 1; $i <= $numCards; $i++) {
            $newCard = $fromHand->discardRandomCard();
            if ($newCard != null) {
                $this->hand[] = $newCard;
            }
        }
    }

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

    public function fillWithCards(): void
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

    public function getValueCards(): int
    {
        $val = 0;
        foreach ($this->hand as $card) {
            $val += $card->getValue();
        }
        return $val;
    }

    public function getNumberCards(): int
    {
        return Count($this->hand);
    }

    public function getAllRaw(): array
    {
        $listReturn = [];
        foreach ($this->hand as $card) {
            $listReturn[] = $card->getCardRaw();
        }
        return $listReturn;
    }

    public function debugPrintHand(): void
    {
        foreach ($this->hand as $card) {
            echo($card->viewCard());
        }
    }
}
