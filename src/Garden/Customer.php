<?php


namespace App\Garden;


class Customer
{
    private $listPlants;
    private $orderItems;

    public function __construct(array $listPossiblePlants)
    {
        $this->listPlants = $listPossiblePlants;
        shuffle($this->listPlants);
        $this->orderItems = array_slice($this->listPlants, 0, 3);
    }

    public function getOrderMessage() {
        $orderItems = $this->orderItems;
        $message = "Hi, I would like one " . $orderItems[0] . ", " . $orderItems[1] . "and " . $orderItems[2] . ", thanks!";
        return $message;
    }
}
