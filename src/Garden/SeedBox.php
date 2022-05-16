<?php

/**
 * Module with Seedbox class.
 */

namespace App\Garden;

/**
 * Holds information of seeds you can plant in garden
 */
class SeedBox
{
    private array $seedBox = [];

    private array $defaultList = array(
        "potato" => 5,
        "tomato" => 13,
        "cucumber" => 6,
        "leek" => 7,
        "carrot" => 10,
        "aubergin" => 15
    );

    /**
     * Constructor. If no alternative seeds are stated the seed box will be filled with a default list of seeds.
     * @param array<string, int> $alternativeSeeds Use name as key and price as value. If left null the seed box will be filled with a default list of seeds.
     * @return void
     */
    public function __construct(array $alternativeSeeds = [])
    {
        if ($alternativeSeeds) {
            foreach ($alternativeSeeds as $name => $price) {
                $this->addSeed($name, $price);
            }
        } else {
            foreach ($this->defaultList as $name => $price) {
                $this->addSeed($name, $price);
            }
        }
    }

    /**
     * Adds a seed that seed box hold.
     */
    public function addSeed(string $name, int $price): void
    {
        $this->seedBox[$name] = $price;
    }

    /**
     * Returns an array with all seeds.
     * @return array<string, int>
     */
    public function getSeedBox(): array
    {
        return $this->seedBox;
    }

    /**
     * Returns an array with all seed names.
     * @return string[]
     */
    public function getSeedNames(): array
    {
        $listReturn = [];
        foreach (array_keys($this->seedBox) as $key) {
            $listReturn[] = $key;
        }
        return $listReturn;
    }
}
