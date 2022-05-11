<?php


namespace App\Garden;


class SeedBox
{

    private array $seedBox = [];

    private array $listSeeds = array(
        "potato" => 5,
        "tomato" => 13,
        "cucumber" => 6,
        "leek" => 7,
        "carrot" => 10,
        "aubergin" => 15
    );

    public function __construct(array $additionlSeeds = [])
    {
        foreach ($additionlSeeds as $name => $price) {
            $this->listSeeds[$name] = $price;
        }
        foreach ($this->listSeeds as $name => $price) {
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

    public function getSeedNames() {
        $listReturn = [];
        foreach ($this->listSeeds as $key => $value) {
            $listReturn[] = $key;
        }
        return $listReturn;
    }
}
