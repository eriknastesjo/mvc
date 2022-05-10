<?php


namespace App\Garden;


class Garden
{
    private array $flowers = [];

    public function __construct(int $groundNum)
    {
        for ($i = 1; $i <= $groundNum; $i++) {
            $index = "ground" . strval($i);
            $this->flowers[$index] = new Flower("empty", 0);
            // array_push($this->flowers, null);
        }
    }

    public function plantSeed(string $name, int $price, string $index)
    {
        $this->flowers[$index] = new Flower($name, $price);
    }

    public function waterFlower(string $index) {
        $this->flowers[$index]->incrementGrowth();
    }

    public function getGarden() {
        return $this->flowers;
    }

}
