<?php


namespace App\Garden;


class Garden
{
    private array $flowers = [];
    private int $numberSold = 0;
    private int $totalIncome = 0;

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

    public function sellAll() {
        $newIncome = 0;
        foreach ($this->flowers as $plant) {
            $this->numberSold++;
            $this->totalIncome += $plant->getPrice();
            $newIncome += $plant->getPrice();
        }
        return $newIncome;
    }

    public function reset(int $groundNum) {
        $this->flowers = [];
        $this->__construct($groundNum);
    }

    public function getTotalIncome() {
        return $this->totalIncome;
    }

    public function getNumberSold() {
        return $this->numberSold;
    }

}
