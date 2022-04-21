<?php

/**
 * Module with Card class
 */

namespace App\Card;

/**
 * Holds information of a single card object, eg. color and value.
 */
class Card
{
    private string $color;
    private string $strValue;
    private int $realValue;

    /**
     * Constructor of the class.
     *
     * @param string $color Type either "heart", "diamond", "spade", "clove" or "joker". Otherwise the card will get the symbol '?'.
     * @param string $strValue This is the value that will be visible on a card. For example choose 'K' to show that the card is a king.
     * @param int $realValue This is the invisible real card value. For example the king card usually have the real value of 13.
     */
    public function __construct(string $color, string $strValue, int $realValue)
    {
        $this->color = $this->chooseSymbol($color);
        $this->strValue = $strValue;
        $this->realValue = $realValue;
    }

    /**
     * Private method to choose correct color based on string value.
     */
    private function chooseSymbol(string $col): string
    {
        if ($col == "heart") {
            return '♥';
        }
        if ($col == "diamond") {
            return '♦';
        }
        if ($col == "spade") {
            return '♠';
        }
        if ($col == "clove") {
            return '☘';
        }
        if ($col == "joker") {
            return '🤡';
        }
        return '?';
    }

    /**
     * Returns a viewable image of the card in form of a string. Does not return the real value of the card.
     */
    public function viewCard(): string
    {
        return "[{$this->color}{$this->strValue}]";
    }

    /**
     * Returns the realValue of the card.
     */
    public function getValue(): int
    {
        return $this->realValue;
    }

    /**
     * Returns an array of raw information about the card. The information contains of the color, the string value and the real value.
     */
    public function getCardRaw(): array
    {
        return array(
                "color" => $this->color,
                "strValue" => $this->strValue,
                "value" => $this->realValue
            );
    }
}
