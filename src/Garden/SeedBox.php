<?php


namespace App\Garden;


class SeedBox
{

    private array $seedBox = [];

    private array $defaultSeeds = array(
        "potato" => 5,
        "tomato" => 13,
        "cucumber" => 6,
        "leek" => 7,
        "carrot" => 10,
        "aubergin" => 15
    );

    public function __construct(array $additionlSeeds = [])
    {
        foreach ($this->defaultSeeds as $name => $price) {
            $this->addSeed($name, $price);
        }
        foreach ($additionlSeeds as $name => $price) {
            $this->addSeed($name, $price);
        }
    }

    public function addSeed(string $name, int $price)
    {
        $this->seedBox[] = new Flower($name, $price);
    }

    public function getSeedBox()
    {
        return $this->seedBox;
    }
}
