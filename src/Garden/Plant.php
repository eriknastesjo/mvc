<?php

/**
 * Module with Plant class.
 */

namespace App\Garden;

/**
 * Holds information and simple methods about a plant
 */
class Plant
{
    private string $name;
    private int $growthLevel;
    private int $price;
    private string $status;
    private int $id;
    private int $maxGrowthLevel;

    /**
     * Constructor
     * @param string $status Can be used to turn plant into a puddle.
     * @param int $id Can be used to relate to row placement in a database table
     * @return void
     */
    public function __construct(
        string $name,
        int $price,
        int $growthLevel = 0,
        string $status = "unsold",
        int $id = -1,
        $maxGrowthLevel = 2
    ) {
        $this->name = $name;
        $this->growthLevel = $growthLevel;
        $this->price = $price;
        $this->status = $status;
        $this->id = $id;
        $this->maxGrowthLevel = $maxGrowthLevel;
    }

    /**
     * Returns the id of the plant.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Sets the id of the plant.
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns the name of the plant.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns the appropriate image url. Includes growth level except when plant name is "empty".
     */
    public function getImageURL(): string
    {
        if ($this->name === "empty") {
            return $this->name;
        }
        return $this->name . $this->growthLevel;
    }

    /**
     * Returns the price of the plant.
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * Returns the status of the plant.
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Sets the status of the plant.
     */
    public function setStatus(string $newStatus): void
    {
        $this->status = $newStatus;
    }

    /**
     * Increses growth level by 1. If growth level is already 2 the plant will turn into a puddle instead.
     */
    public function incrementGrowth(): void
    {
        if ($this->growthLevel < $this->maxGrowthLevel) {
            $this->growthLevel++;
            return;
        }
        $this->name = "puddle";
        $this->price = 0;
        $this->status = "overflown";
    }

    /**
     * Returns the growth level of the plant.
     */
    public function getGrowthLevel(): int
    {
        return $this->growthLevel;
    }

    /**
     * Returns the growth level of the plant.
     */
    public function getMaxGrowthLevel(): int
    {
        return $this->maxGrowthLevel;
    }

    /**
     * If the plant status is "overflown" it will change status to "destroyed.
     * If plant status is already "destroyed" it will "reset" into an empty plant.
     */
    public function checkIfDestroyedOrPuddle(): void
    {
        if ($this->status === "destroyed") {
            $this->__construct("empty", 0);
        } elseif ($this->status === "overflown") {
            $this->status = "destroyed";
        }
    }
}
