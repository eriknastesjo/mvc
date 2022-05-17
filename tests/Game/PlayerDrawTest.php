<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class PlayerDraw.
 */
class PlayerDrawTest extends TestCase
{
    /**
     * Construct PlayerDraw object with no arguments and verify that the objects are of expected instance.
     */
    public function testCreatePlayerDrawNoArguments()
    {
        $playerDraw = new PlayerDraw();
        $this->assertInstanceOf("\App\Card\PlayerDraw", $playerDraw);
    }

    /**
     * Construct Card objects with different arguments and verify that the objects are of expected instance.
     */
    public function testCreatePlayerDrawDifferentArguments()
    {
        $playerDraw = new PlayerDraw(1);
        $this->assertInstanceOf("\App\Card\PlayerDraw", $playerDraw);
        $playerDraw = new PlayerDraw(3);
        $this->assertInstanceOf("\App\Card\PlayerDraw", $playerDraw);
    }

    /**
     * Call getNumberCardsDeck and verify that the returned value is 52.
     */
    public function testGetNumberCardsDeck()
    {
        $playerDraw = new PlayerDraw();
        $this->assertEquals(52, $playerDraw->getNumberCardsDeck());
    }

    /**
     * Call getCardIllustrationsDeck and verify that the returned value contains some cards (string values).
     */
    public function testGetCardIllustrationsDeck()
    {
        $playerDraw = new PlayerDraw();
        $this->assertEquals(52, $playerDraw->getNumberCardsDeck());

        $this->assertContains('[♠K]', $playerDraw->getCardIllustrationsDeck());
        $this->assertContains('[♥5]', $playerDraw->getCardIllustrationsDeck());
        $this->assertContains('[☘8]', $playerDraw->getCardIllustrationsDeck());
        $this->assertContains('[♦Q]', $playerDraw->getCardIllustrationsDeck());
        $this->assertContains('[♠K]', $playerDraw->getCardIllustrationsDeck());
    }


}
