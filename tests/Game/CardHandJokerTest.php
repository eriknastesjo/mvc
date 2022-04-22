<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CardHandJoker.
 */
class CardHandJokerTest extends TestCase
{
    /**
     * Create CardHandJoker object and verify that the objects is of expected instance.
     */
    public function testCreateCardWithDifferentValues()
    {
        $cardHand = new CardHandJoker();
        $this->assertInstanceOf("\App\Card\CardHandJoker", $cardHand);
    }

    /**
     * Fill hand with cards and verify by checking number of cards is 54
     */
    public function testGetNumberOfCardsFullHand()
    {
        $cardHand = new CardHandJoker();
        $cardHand->fillWithCards();
        $this->assertEquals($cardHand->getNumberCards(), 54);
    }

    /**
     * Get total value of cards in filled CardHand.
     * Verifying by checking the total value is of expected value.
     */
    public function testGetValueFilledHand()
    {
        $cardHand = new CardHandJoker();
        $cardHand->fillWithCards();
        $this->assertEquals(446, $cardHand->getValueCards());
    }

    /**
     * Get array of card illustrations from filled CardHand.
     * Verify by checking that array contains a few expected string values.
     */
    public function testGetCardIllustrations()
    {
        $cardHand = new CardHandJoker();
        $cardHand->fillWithCards();
        $this->assertContains('[♥5]', $cardHand->getCardIllustrations());
        $this->assertContains('[☘8]', $cardHand->getCardIllustrations());
        $this->assertContains('[♦Q]', $cardHand->getCardIllustrations());
        $this->assertContains('[♠K]', $cardHand->getCardIllustrations());
        $this->assertContains('[🤡]', $cardHand->getCardIllustrations());
    }

    /**
     * Get array of card illustrations from filled CardHand.
     * Verify by checking that array contains a few expected string values.
     */
    public function testGetCardsRaw()
    {
        $cardHand = new CardHandJoker();
        $cardHand->fillWithCards();

        $this->assertContains(['color' => '♥', 'strValue' => '5', 'value' => 5], $cardHand->getAllRaw());
        $this->assertContains(['color' => '☘', 'strValue' => '8', 'value' => 8], $cardHand->getAllRaw());
        $this->assertContains(['color' => '♦', 'strValue' => 'Q', 'value' => 12], $cardHand->getAllRaw());
        $this->assertContains(['color' => '♠', 'strValue' => 'K', 'value' => 13], $cardHand->getAllRaw());
        $this->assertContains(['color' => '🤡', 'strValue' => '', 'value' => 15], $cardHand->getAllRaw());
    }
}
