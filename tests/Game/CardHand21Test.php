<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CardHand21.
 */
class CardHand21Test extends TestCase
{
    /**
     * Create CardHand21 object and verify that the objects is of expected instance.
     */
    public function testCreateCardWithDifferentValues()
    {
        $cardHand = new CardHand21();
        $this->assertInstanceOf("\App\Card\CardHand21", $cardHand);
    }

    /**
     * Fill hand with cards. Get total minimum value of cards.
     * Ace is supposed to count as 1 instead of 14.
     * Verify by checking value is the expected amount.
     */
    public function testGetValueMin()
    {
        $cardHand = new CardHand21();
        $cardHand->fillWithCards();
        $this->assertEquals(364, $cardHand->getValueCardsMin());
    }

    /**
     * Fill with two low value cards and an ace.
     * In this case ace is supposed to count as 1.
     * Verify by checking value is the expected amount.
     */
    public function testGetOptimalValueMax()
    {
        $cardHand = new CardHand21();

        $possibleColors = array("heart");
        $possibleValues = array(2 => '2', 3 => '3', 14 => 'E');

        $cardHand->fillWithSpecifiedCards($possibleColors, $possibleValues);

        $this->assertEquals(19, $cardHand->getOptimalValueCards());
    }

    /**
     * Fill with two high value cards and an ace.
     * In this case ace is supposed to count as 1.
     * Verify by checking value is the expected amount.
     */
    public function testGetOptimalValueMin()
    {
        $cardHand = new CardHand21();

        $possibleColors = array("heart");
        $possibleValues = array(9 => '9', 10 => '10', 14 => 'E');

        $cardHand->fillWithSpecifiedCards($possibleColors, $possibleValues);

        $this->assertEquals(20, $cardHand->getOptimalValueCards());
    }

}
