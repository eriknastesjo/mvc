<?php

namespace App\Garden;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Customer.
 */
class CustomerTest extends TestCase
{
    /**
     * Construct Customer objects with no arguments and verify that the objects are of expected instance.
     */
    public function testCreateCustomerWithDifferentValues()
    {
        $seedList = ["banana", "apple", "robot"];
        $customer = new Customer($seedList);
        $this->assertInstanceOf("\App\Garden\Customer", $customer);

        $seedList = ["milk", "computer"];
        $customer = new Customer($seedList);
        $this->assertInstanceOf("\App\Garden\Customer", $customer);
    }

    /**
     * Create array with correct plants, then match it with order and verify the returned value is true.
     */
    public function testMatchOrderCorrect()
    {
        $seedList = ["banana", "apple", "robot"];
        $customer = new Customer($seedList);

        $plants = [];
        $plants[] = new Plant("banana", 30, 3, "unsold", 1, 3);
        $plants[] = new Plant("apple", 30, 3, "unsold", 1, 3);
        $plants[] = new Plant("robot", 30, 3, "unsold", 1, 3);

        $this->assertEquals(true, $customer->matchOrder($plants));
    }

    /**
     * Create array with wrong plants, then match it with order and verify the returned value is false.
     */
    public function testMatchOrderWrongPlants()
    {
        $seedList = ["banana", "apple", "robot"];
        $customer = new Customer($seedList);

        $plants = [];
        $plants[] = new Plant("fakePlant1", 30, 3, "unsold", 1, 3);
        $plants[] = new Plant("fakePlant2", 30, 3, "unsold", 1, 3);
        $plants[] = new Plant("fakePlant3", 30, 3, "unsold", 1, 3);

        $this->assertEquals(false, $customer->matchOrder($plants));
    }

    /**
     * Create array with plants with one missing from the order, then match it with order and verify the returned value is false.
     */
    public function testMatchOrderMissingPlant()
    {

        $seedList = ["banana", "apple", "robot"];
        $customer = new Customer($seedList);

        $plants = [];
        $plants[] = new Plant("banana", 30, 3, "unsold", 1, 3);
        $plants[] = new Plant("robot", 30, 3, "unsold", 1, 3);
        $plants[] = new Plant("robot", 30, 3, "unsold", 1, 3);

        $this->assertEquals(false, $customer->matchOrder($plants));
    }

    /**
     * Create array with plants with one not being of max level growth, then match it with order and verify the returned value is false.
     */
    public function testMatchOrderWrongGrowthLevel()
    {

        $seedList = ["banana", "apple", "robot"];
        $customer = new Customer($seedList);

        $plants = [];
        $plants[] = new Plant("banana", 30, 1, "unsold", 1, 3);
        $plants[] = new Plant("apple", 30, 3, "unsold", 1, 3);
        $plants[] = new Plant("robot", 30, 3, "unsold", 1, 3);

        $this->assertEquals(false, $customer->matchOrder($plants));
    }

    /**
     * Get order message without having matched the order yet and verify that it contains the plant names.
     */
    public function testGetOrderMessageUnfinished()
    {

        $seedList = ["banana", "apple", "robot"];
        $customer = new Customer($seedList);

        $this->assertStringContainsString("banana", $customer->getOrderMessage());
        $this->assertStringContainsString("apple", $customer->getOrderMessage());
        $this->assertStringContainsString("robot", $customer->getOrderMessage());
    }

    /**
     * Match the order, then get order message and verify that it is of expected value.
     */
    public function testGetOrderMessageFinished()
    {
        $seedList = ["banana", "apple", "robot"];
        $customer = new Customer($seedList);

        $plants = [];
        $plants[] = new Plant("banana", 30, 3, "unsold", 1, 3);
        $plants[] = new Plant("apple", 30, 3, "unsold", 1, 3);
        $plants[] = new Plant("robot", 30, 3, "unsold", 1, 3);

        $customer->matchOrder($plants);

        $this->assertEquals("Thank you, very nice!", $customer->getOrderMessage());
    }
}
