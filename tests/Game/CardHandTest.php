<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CardHand.
 */
class CardHandTest extends TestCase
{
    /**
     * Create CardHand object and verify that the objects is of expected instance.
     */
    public function testCreateCardWithDifferentValues()
    {
        $cardHand = new CardHand();
        $this->assertInstanceOf("\App\Card\CardHand", $cardHand);
    }

    /**
     * Get number of cards in an empty hand and verify it's zero.
     */
    public function testGetNumberOfCardsEmptyHand()
    {
        $cardHand = new CardHand();
        $this->assertEquals(0, $cardHand->getNumberCards());
    }

    /**
     * Fill hand with full deck and verify by checking number of cards is 52
     */
    public function testGetNumberOfCardsFullHand()
    {
        $cardHand = new CardHand();
        $cardHand->fillWithCards();
        $this->assertEquals(52, $cardHand->getNumberCards());
    }

    /**
     * Fill hand with six specified cards and verify by checking number of cards is 6.
     */
    public function testGetNumberOfCardsSix()
    {
        $cardHand = new CardHand();

        $possibleColors = array("heart", "spade");
        $possibleValues = array(9 => '9', 10 => '10', 14 => 'E');
        $cardHand->fillWithSpecifiedCards($possibleColors, $possibleValues);

        $this->assertEquals(6, $cardHand->getNumberCards());
    }

    /**
     * Discard a card from a hand filled with cards.
     * Verify by checking that it returns an instance of a Card.
     * Verify by checking number of cards is of expected value.
     */
    public function testDiscardCard()
    {
        $cardHand = new CardHand();
        $cardHand->fillWithCards();
        $discardedCard = $cardHand->discardRandomCard();
        $this->assertInstanceOf("\App\Card\Card", $discardedCard);
        $this->assertEquals(51, $cardHand->getNumberCards());
    }

    /**
     * Attempt discarding a card from empty hand.
     * Verify by checking that it returns null.
     * Verify by checking number of cards is zero.
     */
    public function testDiscardCardEmptyHand()
    {
        $cardHand = new CardHand();
        $discardedCard = $cardHand->discardRandomCard();
        $this->assertNull($discardedCard);
        $this->assertEquals($cardHand->getNumberCards(), 0);
    }

    /**
     * Create two CardHand objects and fill one with cards.
     * Let empty CardHand pick one of its cards, no arguments.
     * Verify by checking number of cards is of expected value in both CardHand objects.
     */
    public function testPickCard()
    {
        $cardHand = new CardHand();
        $cardHand2 = new CardHand();
        $cardHand2->fillWithCards();
        $cardHand->pickRandomCard($cardHand2);
        $this->assertEquals(1, $cardHand->getNumberCards());
        $this->assertEquals(51, $cardHand2->getNumberCards());
    }

    /**
     * Create two CardHand objects and fill one with cards.
     * Let empty CardHand pick two of its cards by having argument of number 2.
     * Verify by checking number of cards is of expected value in both CardHand objects.
     */
    public function testPickCardTwo()
    {
        $cardHand = new CardHand();
        $cardHand2 = new CardHand();
        $cardHand2->fillWithCards();
        $cardHand->pickRandomCard($cardHand2, 2);
        $this->assertEquals(2, $cardHand->getNumberCards());
        $this->assertEquals(50, $cardHand2->getNumberCards());
    }

    /**
     * Get total value of cards in empty hand.
     * Verifying by checking the total value is zero.
     */
    public function testGetValueEmptyHand()
    {
        $cardHand = new CardHand();
        $this->assertEquals(0, $cardHand->getValueCards());
    }

    /**
     * Get total value of cards in filled CardHand.
     * Verifying by checking the total value is of expected value.
     */
    public function testGetValueFilledHand()
    {
        $cardHand = new CardHand();
        $cardHand->fillWithCards();
        $this->assertEquals(416, $cardHand->getValueCards());
    }

    /**
     * Get array of card illustrations from filled CardHand.
     * Verify by checking that array contains a few expected string values.
     */
    public function testGetCardIllustrations()
    {
        $cardHand = new CardHand();
        $cardHand->fillWithCards();
        $this->assertContains('[♥5]', $cardHand->getCardIllustrations());
        $this->assertContains('[☘8]', $cardHand->getCardIllustrations());
        $this->assertContains('[♦Q]', $cardHand->getCardIllustrations());
        $this->assertContains('[♠K]', $cardHand->getCardIllustrations());
    }

    /**
     * Get array of card illustrations from filled CardHand.
     * Verify by checking that array contains a few expected string values.
     */
    public function testGetCardsRaw()
    {
        $cardHand = new CardHand();
        $cardHand->fillWithCards();

        $this->assertContains(['color' => '♥', 'strValue' => '5', 'value' => 5], $cardHand->getAllRaw());
        $this->assertContains(['color' => '☘', 'strValue' => '8', 'value' => 8], $cardHand->getAllRaw());
        $this->assertContains(['color' => '♦', 'strValue' => 'Q', 'value' => 12], $cardHand->getAllRaw());
        $this->assertContains(['color' => '♠', 'strValue' => 'K', 'value' => 13], $cardHand->getAllRaw());
    }
}
