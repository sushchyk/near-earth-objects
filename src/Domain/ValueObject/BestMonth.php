<?php

namespace Neo\Domain\ValueObject;

readonly class BestMonth
{
    public function __construct(private Month $month, private int $asteroidsCount)
    {
    }

    public function getMonthNumber(): int
    {
        return $this->month->getNumber();
    }

    public function getMonthFullName(): string
    {
        return $this->month->getFullName();
    }

    public function getAsteroidsCount(): int
    {
        return $this->asteroidsCount;
    }
}
