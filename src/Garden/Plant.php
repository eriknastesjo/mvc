<?php

namespace App\Garden;

class Plant
{
    private string $name;
    private int $growthLevel;
    private int $price;
    private string $status;
    private int $id;

    public function __construct(string $name, int $price, int $growthLevel = 0, string $status = "unsold", int $id = -1)
    {
        $this->name = $name;
        $this->growthLevel = $growthLevel;
        $this->price = $price;
        $this->status = $status;
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getImageURL()
    {
        if ($this->name === "empty") {
            return $this->name;
        }
        return $this->name . $this->growthLevel;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus(string $newStatus)
    {
        $this->status = $newStatus;
    }

    public function incrementGrowth()
    {
        if ($this->growthLevel < 2) {
            $this->growthLevel++;
        } else {
            $this->name = "puddle";
            $this->growthLevel = 3;
            $this->price = 0;
            $this->status = "overflown";
        }
    }

    public function getGrowthLevel()
    {
        return $this->growthLevel;
    }

    public function checkIfDestroyedOrPuddle()
    {
        if ($this->status === "destroyed") {
            $this->__construct("empty", 0);
        } elseif ($this->status === "overflown") {
            $this->status = "destroyed";
        }
    }
}
