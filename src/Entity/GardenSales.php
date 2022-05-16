<?php

/**
 * Module with GardenSales class.
 */

namespace App\Entity;

use App\Repository\GardenSalesRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Query\Expr\Func;

/**
 * Holds data of sold plants, including id, name, price, date and time.
 */
#[ORM\Entity(repositoryClass: GardenSalesRepository::class)]
class GardenSales
{
    // #[ORM\GeneratedValue]
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 25)]
    private $plant;

    #[ORM\Column(type: 'integer')]
    private $price;

    #[ORM\Column(type: 'string', length: 20)]
    private $date;

    #[ORM\Column(type: 'string', length: 10)]
    private $time;


    /**
     * Returns id.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set id.
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Returns plantName.
     */
    public function getPlant(): ?string
    {
        return $this->plant;
    }

    /**
     * Sets plantName.
     */
    public function setPlant(string $plant): self
    {
        $this->plant = $plant;

        return $this;
    }

    /**
     * Returns price of plant.
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * Sets price of plant.
     */
    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Returns the date when the plant was sold.
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * Sets the date when the plant was sold.
     */
    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Returns the time when the plant was sold.
     */
    public function getTime(): ?string
    {
        return $this->time;
    }

    /**
     * Sets the time when the plant was sold.
     */
    public function setTime(string $time): self
    {
        $this->time = $time;

        return $this;
    }
}
