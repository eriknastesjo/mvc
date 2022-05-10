<?php


namespace App\Garden;


class SeedBox
{

    private array $seedBox = [];

    private array $defaultSeeds = array(
        "blue" => 30,
        "red" => 20,
        "yellow" => 25
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
