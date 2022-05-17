<?php

namespace App\Garden;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Plant.
 */
class PlantTest extends TestCase
{
    /**
     * Construct Plant objects with different arguments and verify that the objects are of expected instance.
     */
    public function testCreatePlantWithDifferentValues()
    {
        $plant = new Plant("strawberry", 10, 2, "yummy", 43);
        $this->assertInstanceOf("\App\Garden\Plant", $plant);

        $plant = new Plant("potato", 55, 6, "sleeping", 2);
        $this->assertInstanceOf("\App\Garden\Plant", $plant);

        $plant = new Plant("meatball", 100, 99, "metallic", 31);
        $this->assertInstanceOf("\App\Garden\Plant", $plant);
    }

    /**
     * Get id and verify that it is of expected value.
     */
    public function testGetId()
    {
        $plant = new Plant("strawberry", 10, 2, "yummy", 43);
        $this->assertEquals(43, $plant->getId());

        $plant = new Plant("strawberry", 10, 2, "yummy", 70);
        $this->assertEquals(70, $plant->getId());
    }

    /**
     * Set id, then get it and verify that it is of expected value.
     */
    public function testSetid()
    {
        $plant = new Plant("strawberry", 10, 2, "yummy", 43);
        $plant->setId(42);
        $this->assertEquals(42, $plant->getId());

        $plant = new Plant("strawberry", 10, 2, "yummy", 70);
        $plant->setId(100);
        $this->assertEquals(100, $plant->getId());
    }

    /**
     * Get name and verify that it is of expected value.
     */
    public function testGetName()
    {
        $plant = new Plant("strawberry", 10, 2, "yummy", 43);
        $this->assertEquals("strawberry", $plant->getName());

        $plant = new Plant("potato", 10, 2, "yummy", 70);
        $this->assertEquals("potato", $plant->getName());
    }

    /**
     * Get image URL and verify that it is of expected value.
     * Should include growth level in name unless the name is "empty".
     */
    public function testGetImageURL()
    {
        $plant = new Plant("empty", 10, 2, "yummy", 43);
        $this->assertEquals("empty", $plant->getImageURL());

        $plant = new Plant("strawberry", 10, 2, "yummy", 43);
        $this->assertEquals("strawberry2", $plant->getImageURL());
    }

    /**
     * Get price and verify that it is of expected value.
     */
    public function testGetPrice()
    {
        $plant = new Plant("strawberry", 10, 2, "yummy", 43);
        $this->assertEquals(10, $plant->getPrice());

        $plant = new Plant("strawberry", 22, 2, "yummy", 70);
        $this->assertEquals(22, $plant->getPrice());
    }

    /**
     * Get status and verify that it is of expected value.
     */
    public function testGetStatus()
    {
        $plant = new Plant("strawberry", 10, 2, "yummy", 43);
        $this->assertEquals("yummy", $plant->getStatus());

        $plant = new Plant("strawberry", 22, 2, "red", 70);
        $this->assertEquals("red", $plant->getStatus());
    }

    /**
     * Set status, then get it and verify that it is of expected value.
     */
    public function testSetStatus()
    {
        $plant = new Plant("strawberry", 10, 2, "yummy", 43);
        $plant->setStatus("disgusting");
        $this->assertEquals("disgusting", $plant->getStatus());

        $plant = new Plant("strawberry", 22, 2, "red", 70);
        $plant->setStatus("brown");
        $this->assertEquals("brown", $plant->getStatus());
    }

    /**
     * Get growth level and verify that it is of expected value.
     */
    public function testGetGrowthLevel()
    {
        $plant = new Plant("strawberry", 10, 2, "yummy", 43);
        $this->assertEquals(2, $plant->getGrowthLevel());

        $plant = new Plant("strawberry", 22, 99, "red", 70);
        $this->assertEquals(99, $plant->getGrowthLevel());
    }

    /**
     * Increment growth level, then get it and verify that it is of expected value. If growthLevel already reached max the name should be changed to "puddle" and status to "overflown".
     */
    public function testSetGrowthLevel()
    {
        $plant = new Plant("strawberry", 10, 2, "yummy", 43, 3);
        $plant->incrementGrowth();
        $this->assertEquals(3, $plant->getGrowthLevel());

        $plant = new Plant("strawberry", 10, 2, "yummy", 43);
        $plant->incrementGrowth();
        $this->assertEquals(2, $plant->getGrowthLevel());
        $this->assertEquals("puddle", $plant->getName());
        $this->assertEquals("overflown", $plant->getStatus());

        $plant = new Plant("strawberry", 10, 2, "yummy", 43, 1);
        $plant->incrementGrowth();
        $this->assertEquals(2, $plant->getGrowthLevel());
        $this->assertEquals("puddle", $plant->getName());
        $this->assertEquals("overflown", $plant->getStatus());
    }

    /**
     * Check if status is destroyed or overflown. If destroyed, the object should re-construct with name "empty". If overflown, the status should change to "destroyed".
     */
    public function testCheckIfDestroyedOrPuddle()
    {
        $plant = new Plant("strawberry", 10, 2, "yummy", 43);
        $plant->checkIfDestroyedOrPuddle();
        $this->assertEquals("strawberry", $plant->getName());
        $this->assertEquals("yummy", $plant->getStatus());

        $plant = new Plant("strawberry", 10, 2, "overflown", 43);
        $plant->checkIfDestroyedOrPuddle();
        $this->assertEquals("strawberry", $plant->getName());
        $this->assertEquals("destroyed", $plant->getStatus());

        $plant = new Plant("strawberry", 10, 2, "destroyed", 43);
        $plant->checkIfDestroyedOrPuddle();
        $this->assertEquals("empty", $plant->getName());
    }
}
