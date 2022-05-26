<?php

namespace App\Garden;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class ConvertStrings.
 */
class ConvertStringsTest extends TestCase
{
    /**
     * Construct ConvertStrings objects with different arguments and verify that the objects are of expected instance.
     */
    public function testCreateAcronym()
    {
        $convertStrings = new ConvertStrings();

        $this->assertEquals("erna", $convertStrings->createAcronym("Erik", "Nästesjö Todd"));
        $this->assertEquals("axOl", $convertStrings->createAcronym("Axel", "Ölskevik"));
        $this->assertEquals("tiAl", $convertStrings->createAcronym("Tina", "Ålasson"));
        $this->assertEquals("nana", $convertStrings->createAcronym("Nässan", "Nästesjö"));
        $this->assertEquals("Ashi", $convertStrings->createAcronym("Åsa", "Hirsch"));
        $this->assertEquals("Almo", $convertStrings->createAcronym("Ällen", "Mos"));
    }
}
