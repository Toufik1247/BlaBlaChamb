<?php

namespace App\Entity;

class RideFilter
{
    private $departure;

    private $destination;

    private $minSeats;

    private $maxPrice;

    public function getDeparture(): ?string
    {
        return $this->departure;
    }

    public function setDeparture(?string $departure): self
    {
        $this->departure = $departure;
        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(?string $destination): self
    {
        $this->destination = $destination;
        return $this;
    }

    public function getMinSeats(): ?int
    {
        return $this->minSeats;
    }

    public function setMinSeats(?int $minSeats): self
    {
        $this->minSeats = $minSeats;
        return $this;
    }

    public function getMaxPrice(): ?float
    {
        return $this->maxPrice;
    }

    public function setMaxPrice(?float $maxPrice): self
    {
        $this->maxPrice = $maxPrice;
        return $this;
    }
}