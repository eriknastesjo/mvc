<?php


namespace App\Garden;


class Garden
{
    private array $plants = [];
    private int $numberSold = 0;
    private int $totalIncome = 0;

    public function __construct(int $groundNum)
    {
        for ($i = 1; $i <= $groundNum; $i++) {
            array_push($this->plants, new Plant("empty", 0));
        }
    }

    public function plantSeed(string $name, int $price, string $index)
    {
        $this->plants[$index] = new Plant($name, $price);
    }

    public function waterPlant(string $index) {
        $this->plants[$index]->incrementGrowth();
    }

    public function getPlant($index) {
        return $this->plants[$index];
    }

    public function getGarden() {
        return $this->plants;
    }

    public function sellAll() {
        $newIncome = 0;
        foreach ($this->plants as $plant) {
            $this->numberSold++;
            $this->totalIncome += $plant->getPrice();
            $newIncome += $plant->getPrice();
        }
        return $newIncome;
    }

    public function reset(int $groundNum) {
        $this->plants = [];
        $this->__construct($groundNum);
    }

    public function getTotalIncome() {
        return $this->totalIncome;
    }

    public function getNumberSold() {
        return $this->numberSold;
    }

}
