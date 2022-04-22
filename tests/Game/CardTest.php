<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class CardTest extends TestCase
{
    /**
     * Construct Card objects with different arguments and verify that the objects are of expected instance.
     */
    public function testCreateCardWithDifferentValues()
    {
        $card = new Card('heart', 'Q', 12);
        $this->assertInstanceOf("\App\Card\Card", $card);
        $card = new Card('clove', '10', 10);
        $this->assertInstanceOf("\App\Card\Card", $card);
        $card = new Card('diamond', '3', 3);
        $this->assertInstanceOf("\App\Card\Card", $card);
        $card = new Card('spade', 'K', 13);
        $this->assertInstanceOf("\App\Card\Card", $card);
        $card = new Card('joker', 'E', 14);
        $this->assertInstanceOf("\App\Card\Card", $card);
        $card = new Card('nonsense', '2', 2);
        $this->assertInstanceOf("\App\Card\Card", $card);
    }

    /**
     * Get card illustration and verify it has expected string value
     */
    public function testGetCardIllustration()
    {
        $card = new Card('heart', 'Q', 12);
        $this->assertEquals('[♥Q]', $card->getIllustration());
        $card = new Card('clove', '10', 10);
        $this->assertEquals('[☘10]', $card->getIllustration());
        $card = new Card('diamond', '3', 3);
        $this->assertEquals('[♦3]', $card->getIllustration());
        $card = new Card('spade', 'K', 13);
        $this->assertEquals('[♠K]', $card->getIllustration());
        $card = new Card('joker', 'E', 14);
        $this->assertEquals('[🤡E]', $card->getIllustration());
        $card = new Card('nonsense', '2', 2);
        $this->assertEquals('[?2]', $card->getIllustration());
    }

    /**
     * Get card value and verify it has expected int value
     */
    public function testGetCardValue()
    {
        $card = new Card('heart', 'Q', 12);
        $this->assertEquals(12, $card->getValue());
        $card = new Card('clove', '10', 10);
        $this->assertEquals(10, $card->getValue());
        $card = new Card('diamond', '3', 3);
        $this->assertEquals(3, $card->getValue());
        $card = new Card('spade', 'K', 13);
        $this->assertEquals(13, $card->getValue());
        $card = new Card('joker', 'E', 14);
        $this->assertEquals(14, $card->getValue());
        $card = new Card('nonsense', '2', 2);
        $this->assertEquals(2, $card->getValue());
    }

    /**
     * Get card in raw format and verify it has expected values
     */
    public function testGetCardRaw()
    {
        $card = new Card('heart', 'Q', 12);
        $this->assertEquals(['color' => '♥', 'strValue' => 'Q', 'value' => 12], $card->getCardRaw());
        $card = new Card('clove', '10', 10);
        $this->assertEquals(['color' => '☘', 'strValue' => '10', 'value' => 10], $card->getCardRaw());
        $card = new Card('diamond', '3', 3);
        $this->assertEquals(['color' => '♦', 'strValue' => '3', 'value' => 3], $card->getCardRaw());
        $card = new Card('spade', 'K', 13);
        $this->assertEquals(['color' => '♠', 'strValue' => 'K', 'value' => 13], $card->getCardRaw());
        $card = new Card('joker', 'E', 14);
        $this->assertEquals(['color' => '🤡', 'strValue' => 'E', 'value' => 14], $card->getCardRaw());
        $card = new Card('nonsense', '2', 2);
        $this->assertEquals(['color' => '?', 'strValue' => '2', 'value' => 2], $card->getCardRaw());
    }
}
