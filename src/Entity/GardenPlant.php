<?php

namespace App\Entity;

use App\Repository\GardenPlantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GardenPlantRepository::class)]
class GardenPlant
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlant(): ?string
    {
        return $this->plant;
    }

    public function setPlant(string $plant): self
    {
        $this->plant = $plant;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTime(): ?string
    {
        return $this->time;
    }

    public function setTime(string $time): self
    {
        $this->time = $time;

        return $this;
    }
}
