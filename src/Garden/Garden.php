<?php

/**
 * Module with Garden class.
 */

namespace App\Garden;

/**
 * A Garden handles one or more Plant objects.
 */
class Garden
{
    private array $plants = [];
    private int $numberSold = 0;
    private int $totalIncome = 0;

    /**
     * Constructor
     * @param int $emptySpotNum Equals how many plants it can hold.
     * @return void
     */
    public function __construct(int $emptySpotNum = 3)
    {
        for ($i = 1; $i <= $emptySpotNum; $i++) {
            array_push($this->plants, new Plant("empty", 0));
        }
    }

    /**
     * Will create a plant with growth level 0.
     * @param int $plantIndex Relates to the list of plants that the object holds.
     * State a number between 0 and number of held plants.
     * @return void
     */
    public function plantSeed(string $plantName, int $price, int $plantIndex)
    {
        $this->plants[$plantIndex] = new Plant($plantName, $price);
    }

    /**
     * Will increase growth level of a plant by 1.
     * @param int $plantIndex Relates to the list of plants that the object holds.
     * State a number between 0 and number of held plants.
     * @return void
     */
    public function waterPlant(int $plantIndex)
    {
        $this->plants[$plantIndex]->incrementGrowth();
    }

    /**
     * Get a Plant object from the garden
     * @param int $plantIndex Relates to the list of plants that the object holds.
     * State a number between 0 and number of held plants.
     * @return Plant
     */
    public function getPlant($plantIndex): Plant
    {
        return $this->plants[$plantIndex];
    }

    /**
     * Get an array with all Plant Objects from the garden
     * @return Plant[]
     */
    public function getAllPlants(): array
    {
        return $this->plants;
    }

    /**
     * This will calculate and return the price sum of the Plant Objects in the garden.
     * This will also add it to the total income.
     */
    public function sellAll(): int
    {
        $newIncome = 0;
        foreach ($this->plants as $plant) {
            $this->numberSold++;
            $this->totalIncome += $plant->getPrice();
            $newIncome += $plant->getPrice();
        }
        return $newIncome;
    }


    /**
     * Deleting current Plant objects in garden and adds new empty Plant objects.
     * @param int $emptySpotNum Equals how many plants the garden will hold.
     */
    public function reset(int $emptySpotNum): void
    {
        $this->plants = [];
        $this->__construct($emptySpotNum);
    }

    /**
     * Returns the total of income for all the Plant objects that has been sold.
     */
    public function getTotalIncome(): int
    {
        return $this->totalIncome;
    }

    /**
     * Returns the number of Plant objects that has been sold.
     */
    public function getNumberSold(): int
    {
        return $this->numberSold;
    }
}
