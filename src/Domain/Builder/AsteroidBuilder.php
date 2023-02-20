<?php

namespace Neo\Domain\Builder;

use Neo\Domain\Entity\AsteroidEntity;

class AsteroidBuilder
{
    private string $name;
    private string $referenceId;
    private \DateTimeImmutable $date;
    private float $speed;
    private bool $isHazardous;

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function setReferenceId(string $referenceId): static
    {
        $this->referenceId = $referenceId;
        return $this;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;
        return $this;
    }

    public function setSpeed(float $speed): static
    {
        $this->speed = $speed;
        return $this;
    }

    public function setIsHazardous(bool $isHazardous): static
    {
        $this->isHazardous = $isHazardous;
        return $this;
    }

    public function build(): AsteroidEntity
    {
        $asteroidEntity = new AsteroidEntity($this->name, $this->referenceId, $this->date, $this->speed, $this->isHazardous);
        $this->reset();
        return $asteroidEntity;
    }

    private function reset(): void
    {
        unset($this->name, $this->referenceId, $this->date, $this->speed, $this->isHazardous);
    }

}
