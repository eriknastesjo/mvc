<?php

namespace App\Garden;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Garden.
 */
class GardenTest extends TestCase
{
    /**
     * Construct Garden objects with no arguments and verify that the objects are of expected instance.
     */
    public function testCreateGardenWithNoValues()
    {
        $garden = new Garden();
        $this->assertInstanceOf("\App\Garden\Garden", $garden);
    }

    /**
     * Construct Garden objects with different arguments and verify that the objects are of expected instance.
     */
    public function testCreateGardenWithDifferentValues()
    {
        $garden = new Garden(1);
        $this->assertInstanceOf("\App\Garden\Garden", $garden);

        $garden = new Garden(5);
        $this->assertInstanceOf("\App\Garden\Garden", $garden);
    }

    /**
     * Get a plant with certain index and verify that it is of expected instance.
     */
    public function testGetPlant()
    {
        $garden = new Garden(2);
        $this->assertInstanceOf("\App\Garden\Plant", $garden->getPlant(0));

        $garden = new Garden(2);
        $this->assertInstanceOf("\App\Garden\Plant", $garden->getPlant(1));
    }

    /**
     * Get all plants and verify that it is an array with expected quantity.
     */
    public function testGetAllPlantArray()
    {
        $garden = new Garden(1);
        $this->assertIsArray($garden->getAllPlants());
        $this->assertEquals(1, count($garden->getAllPlants()));

        $garden = new Garden(5);
        $this->assertIsArray($garden->getAllPlants());
        $this->assertEquals(5, count($garden->getAllPlants()));
    }

    /**
     * Get all plants and verify that the array is filled with objects of expected instances.
     */
    public function testGetAllPlantInstances()
    {
        $garden = new Garden(1);
        foreach ($garden->getAllPlants() as $plant) {
            $this->assertInstanceOf("\App\Garden\Plant", $plant);
        }

        $garden = new Garden(5);
        foreach ($garden->getAllPlants() as $plant) {
            $this->assertInstanceOf("\App\Garden\Plant", $plant);
        }
    }

    /**
     * Plant a seed and verify that the object is of expected instance.
     */
    public function testPlantSeedObject()
    {
        $garden = new Garden(1);
        $garden->plantSeed("banana", 30, 0);
        $this->assertInstanceOf("\App\Garden\Plant", $garden->getPlant(0));

        $garden = new Garden(1);
        $garden->plantSeed("chocolate", 10, 0);
        $this->assertInstanceOf("\App\Garden\Plant", $garden->getPlant(0));
    }

    /**
     * Plant a seed with different indexes and verify that the object has the expected property values.
     */
    public function testPlantSeedValues()
    {
        $garden = new Garden(1);
        $garden->plantSeed("banana", 30, 0);
        $this->assertEquals("banana", $garden->getPlant(0)->getName());
        $this->assertEquals(30, $garden->getPlant(0)->getPrice());

        $garden = new Garden(2);
        $garden->plantSeed("chocolate", 10, 1);
        $this->assertEquals("chocolate", $garden->getPlant(1)->getName());
        $this->assertEquals(10, $garden->getPlant(1)->getPrice());
    }

    /**
     * Water a plant and verify that growthlevel has increased by 1.
     */
    public function testWaterPlant()
    {
        $garden = new Garden(1);
        $garden->plantSeed("banana", 30, 0);
        $preGrowthLvl = $garden->getPlant(0)->getGrowthLevel();
        $garden->waterPlant(0);
        $postGrowthLvl = $garden->getPlant(0)->getGrowthLevel();
        $this->assertEquals(1, $postGrowthLvl - $preGrowthLvl);
    }

    /**
     * Sell all plants and verify the returned value
     */
    public function testSellAll()
    {
        $garden = new Garden(1);
        $garden->plantSeed("banana", 30, 0);
        $this->assertEquals(30, $garden->sellAll());

        $garden = new Garden(2);
        $garden->plantSeed("banana", 30, 0);
        $garden->plantSeed("apple", 50, 1);
        $this->assertEquals(80, $garden->sellAll());
    }

    /**
     * Sell all plants, get total income and very it is of exptected value.
     */
    public function testGetTotalIncome()
    {
        $garden = new Garden(1);
        $garden->plantSeed("banana", 30, 0);
        $garden->sellAll();
        $this->assertEquals(30, $garden->getTotalIncome());

        $garden = new Garden(2);
        $garden->plantSeed("banana", 30, 0);
        $garden->plantSeed("apple", 50, 1);
        $garden->sellAll();
        $this->assertEquals(80, $garden->getTotalIncome());

        $garden = new Garden(2);
        $garden->plantSeed("banana", 30, 0);
        $garden->plantSeed("apple", 50, 1);
        $garden->sellAll();
        $garden->plantSeed("sock", 10, 0);
        $garden->plantSeed("jumper", 60, 1);
        $garden->sellAll();
        $this->assertEquals(150, $garden->getTotalIncome());
    }

    /**
     * Sell all plants, get number sold and very it is of exptected value.
     */
    public function testGetNumberSold()
    {
        $garden = new Garden(1);
        $garden->plantSeed("banana", 30, 0);
        $garden->sellAll();
        $this->assertEquals(1, $garden->getNumberSold());

        $garden = new Garden(2);
        $garden->plantSeed("banana", 30, 0);
        $garden->plantSeed("apple", 50, 1);
        $garden->sellAll();
        $this->assertEquals(2, $garden->getNumberSold());

        $garden = new Garden(2);
        $garden->plantSeed("banana", 30, 0);
        $garden->plantSeed("apple", 50, 1);
        $garden->sellAll();
        $garden->plantSeed("sock", 10, 0);
        $garden->plantSeed("jumper", 60, 1);
        $garden->sellAll();
        $this->assertEquals(4, $garden->getNumberSold());
    }

}
