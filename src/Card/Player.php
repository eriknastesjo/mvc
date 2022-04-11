<?php

namespace App\Card;

use App\Card\CardHand;

class Player
{
    private $cardHand;

    public function __construct()
    {
        $this->cardHand = new CardHand();
    }

    public function viewHand(): array
    {
        return $this->cardHand->viewHand();
    }
}
