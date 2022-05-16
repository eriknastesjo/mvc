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
    public function __construct(array $listPossiblePlants)
    {
        shuffle($listPossiblePlants);
        $this->orderItems = array_slice($listPossiblePlants, 0, 3);
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
     * @param Garden[] $garden Use array of Garden objects.
     */
    public function matchOrder(array $garden): bool
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
