<?php

namespace Neo\Domain\Repository;

use Neo\Domain\Entity\AsteroidEntity;
use Neo\Domain\Exception\NoAsteroidsFoundException;
use Neo\Domain\Filter\AsteroidFilter;
use Neo\Domain\ValueObject\BestMonth;

interface AsteroidRepository
{
    /**
     * @throws NoAsteroidsFoundException
     */
    public function getBestMonthInCurrentYear(AsteroidFilter $asteroidFilter): BestMonth;

    /**
     * @throws NoAsteroidsFoundException
     */
    public function getFastest(AsteroidFilter $asteroidFilter): AsteroidEntity;

    /**
     * @return AsteroidEntity[]
     */
    public function findHazardous(): array;
}
