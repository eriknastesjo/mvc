<?php

namespace App\Garden;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class SeedBox.
 */
class SeedBoxTest extends TestCase
{
    /**
     * Construct SeedBox objects with no arguments and verify that the objects are of expected instance.
     */
    public function testCreateSeedBoxNoArguments()
    {
        $seedBox = new SeedBox();
        $this->assertInstanceOf("\App\Garden\SeedBox", $seedBox);
    }

    /**
     * Construct SeedBox objects with different arguments and verify that the objects are of expected instance.
     */
    public function testCreateSeedBoxDifferentArguments()
    {
        $customSeedBox = ["bird" => 10, "melon" => 20];
        $seedBox = new SeedBox($customSeedBox);
        $this->assertInstanceOf("\App\Garden\SeedBox", $seedBox);

        $customSeedBox = ["bird" => 10, "melon" => 20, "burger" => 33];
        $seedBox = new SeedBox($customSeedBox);
        $this->assertInstanceOf("\App\Garden\SeedBox", $seedBox);
    }

    /**
     * Get seedBox and verify that it is of expected value.
     */
    public function testGetSeedBox()
    {
        $customSeedBox = ["bird" => 10, "melon" => 20];
        $seedBox = new SeedBox($customSeedBox);
        $this->assertEquals($customSeedBox, $seedBox->getSeedBox());
    }

    /**
     * Get seedBox names and verify that they are of expected value.
     */
    public function testGetSeedNames()
    {
        $names = ["bird", "melon"];
        $customSeedBox = ["bird" => 10, "melon" => 20];
        $seedBox = new SeedBox($customSeedBox);

        $this->assertEquals(true, empty(array_diff($names, $seedBox->getSeedNames())));
        $this->assertEquals(true, empty(array_diff($seedBox->getSeedNames(), $names)));
    }
}
