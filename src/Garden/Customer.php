<?php

/**
 * Module with Customer class.
 */

namespace App\Garden;

/**
 * Holds information about an order and matches it to defiened plants.
 */
class Customer
{
    private array $orderItems;
    private bool $hasFinishedOrder = false;

    /**
     * Constructor injects a list of possible plants and chooses three random ones.
     * @param string[] $listPossiblePlants Use array of string names.
     * @return void
     */
    public function __construct(array $listPossiblePlants, int $itemNum = 3)
    {
        shuffle($listPossiblePlants);
        $this->orderItems = array_slice($listPossiblePlants, 0, $itemNum);
    }

    /**
     * Returns an appropriate message depending if the order has been matched or not.
     */
    public function getOrderMessage(): string
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

    /**
     * Both checks if all plants are full grown and if they match the order.
     * @param Plant[] $allPlants Use array of Plant objects.
     */
    public function matchOrder(array $allPlants): bool
    {
        $isCorrectItems = true;
        $listNames = [];

        // checks if plants are full grown
        foreach ($allPlants as $plant) {
            if ($plant->getGrowthLevel() !== $plant->getMaxGrowthLevel()) {
                $isCorrectItems = false;
            }
            $listNames[] = $plant->getName();
        }

        // checks if all plant names from order
        // are represented in garden
        if (!empty(array_diff($this->orderItems, $listNames))) {
            $isCorrectItems = false;
        }

        if ($isCorrectItems) {
            $this->hasFinishedOrder = true;
        }
        return $isCorrectItems;
    }
}
