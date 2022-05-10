<?php


namespace App\Garden;


class Flower
{

    private string $name;
    private int $growthLevel;
    private int $price;
    private string $status;

    public function __construct(string $name, int $price, int $growthLevel = 0, string $status = "unsold")
    {
        $this->name = $name;
        $this->growthLevel = $growthLevel;
        $this->price = $price;
        $this->status = $status;
    }

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function incrementGrowth() {
        if ($this->growthLevel < 2) {
            $this->growthLevel++;
        }
    }

    public function setStatus(string $newStatus) {
        $this->status = $newStatus;
    }

}
