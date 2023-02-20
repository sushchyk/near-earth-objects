<?php

namespace Neo\App\Service;

use Neo\Domain\Entity\AsteroidEntity;
use Neo\Domain\Exception\NoAsteroidsFoundException;
use Neo\Domain\Filter\AsteroidFilter;
use Neo\Domain\Repository\AsteroidRepository;
use Neo\Domain\ValueObject\BestMonth;

readonly class AsteroidService
{
    public function __construct(private AsteroidRepository $asteroidRepository)
    {
    }

    /**
     * @return AsteroidEntity[]
     */
    public function getHazardousAsteroids(): array
    {
        return $this->asteroidRepository->findHazardous();
    }

    /**
     * @throws NoAsteroidsFoundException
     */
    public function getBestMonthInTheCurrentYear(AsteroidFilter $asteroidFilter): BestMonth
    {
        return $this->asteroidRepository->getBestMonthInCurrentYear($asteroidFilter);
    }

    /**
     * @throws NoAsteroidsFoundException
     */
    public function getFastestAsteroid(AsteroidFilter $asteroidFilter): AsteroidEntity
    {
        return $this->asteroidRepository->getFastest($asteroidFilter);
    }
}
