<?php

namespace Neo\Domain\Filter;

class AsteroidFilter
{
    private bool $isHazardous;

    public function __construct(bool $isHazardous)
    {
        $this->isHazardous = $isHazardous;
    }

    public function getIsHazardous(): bool
    {
        return $this->isHazardous;
    }
}
