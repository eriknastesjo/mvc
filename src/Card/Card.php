<?php

namespace App\Card;

class Card
{
    private string $color;
    private string $strValue;
    private int $realValue;

    public function __construct(string $color, string $strValue, int $realValue)
    {
        $this->color = $this->ChooseSymbol($color);
        $this->strValue = $strValue;
        $this->realValue = $realValue;
    }

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

    public function viewCard(): string
    {
        return "[{$this->color}{$this->strValue}]";
    }

    public function getValue(): string
    {
        return $this->realValue;
    }

    public function getCardRaw(): array {
        return array(
                "color" => $this->color,
                "strValue" => $this->strValue,
                "value" => $this->realValue
            );
    }
}
