<?php

/**
 * Module with GardenPlantedSeeds class.
 */

namespace App\Entity;

use App\Repository\GardenPlantedSeedsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Holds data of planted seeds, including id, name, date and time.
 */
#[ORM\Entity(repositoryClass: GardenPlantedSeedsRepository::class)]
class GardenPlantedSeeds
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 25)]
    private $plant;

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
     * Returns the date when the seed was planted.
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * Sets the date when the seed was planted.
     */
    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Returns the time when the seed was planted.
     */
    public function getTime(): ?string
    {
        return $this->time;
    }

    /**
     * Sets the time when the seed was planted.
     */
    public function setTime(string $time): self
    {
        $this->time = $time;

        return $this;
    }
}
