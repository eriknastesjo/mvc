<?php

namespace App\Garden;

class Customer
{
    private $orderItems;
    private $hasFinishedOrder = false;

    public function __construct(array $listPossiblePlants)
    {
        shuffle($listPossiblePlants);
        $this->orderItems = array_slice($listPossiblePlants, 0, 3);
    }

    public function getOrderMessage()
    {
        if ($this->hasFinishedOrder) {
            return "Thank you, very nice!";
        }
        $orderItems = $this->orderItems;
        $message = "Hi, I would like one " .
        $orderItems[0] .
        ", " .
        $orderItems[1] .
        " and " .
        $orderItems[2] .
        ", please!";
        return $message;
    }

    public function matchOrder(array $garden)
    {
        $isCorrectItems = true;

        // checks if plants are full grown
        foreach ($garden as $plant) {
            if ($plant->getGrowthLevel() !== 2) {
                $isCorrectItems = false;
            }
        }

        // checks if plants are the correct types
        foreach ($garden as $plant) {
            if (!in_array($plant->getName(), $this->orderItems, true)) {
                $isCorrectItems = false;
            }
        }

        if ($isCorrectItems) {
            $this->hasFinishedOrder = true;
        }
        return $isCorrectItems;
    }
}
