<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Player21.
 */
class Player21Test extends TestCase
{
    /**
     * Create PlayerDraw object and verify that the objects are of expected instance.
     */
    public function testCreatePlayer21()
    {
        $player21 = new Player21();
        $this->assertInstanceOf("\App\Card\Player21", $player21);
    }

    // /**  ERROR: Blir ju finished om man får över 21 så detta testet får strykas!
    //  * Call isFinished right after creating a new instance and verify that it returns the expected value.
    //  */
    // public function testIsFinished()
    // {
    //     $player21 = new Player21();
    //     $this->assertEquals(false, $player21->isFinished());
    // }

    /**
     * Call setIsFinished and then isFinished and verify it returns the expected values.
     */
    public function testSetIsFinished()
    {
        $player21 = new Player21();
        $player21->setIsFinished(true);
        $this->assertEquals(true, $player21->isFinished());
        $player21->setIsFinished(false);
        $this->assertEquals(false, $player21->isFinished());
    }
}
