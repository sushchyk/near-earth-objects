<?php

namespace Neo\Presentation\Presenter;

use Neo\Domain\Entity\AsteroidEntity;

class AsteroidPresenter
{
    public function present(AsteroidEntity $asteroidEntity): array
    {
        return [
            'id' => $asteroidEntity->getId(),
            'name' => $asteroidEntity->getName(),
            'referenceId' => $asteroidEntity->getReferenceId(),
            'date' => $asteroidEntity->getDate()->format('Y-m-d'),
            'speed' => $asteroidEntity->getSpeed(),
            'isHazardous' => $asteroidEntity->isHazardous(),
        ];
    }
}
