<?php


namespace App\Garden;


class Garden
{
    private array $flowers = [];

    public function __construct(int $groundNum)
    {
        for ($i = 1; $i <= $groundNum; $i++) {
            // $index = "ground" . strval($i);
            // $this->flowers[$index] = new Flower("empty", 0);
            array_push($this->flowers, new Flower("empty", 0));
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

    public function resetGarden(int $groundNum) {
        $this->flowers = [];
        $this->__construct($groundNum);
    }

    // public function getNamesPlants() {
    //     $listReturn = [];
    //     foreach ($this->flowers as $plant) {
    //         $listReturn[] = $plant->getName();
    //     }
    //     return $listReturn;
    // }

}
