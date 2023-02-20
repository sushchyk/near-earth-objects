<?php

namespace Neo\Presentation\Controller\Api;

use Neo\App\Service\AsteroidService;
use Neo\Domain\Entity\AsteroidEntity;
use Neo\Presentation\Presenter\AsteroidPresenter;
use Neo\Presentation\Response\SuccessResponse;
use Symfony\Component\HttpFoundation\Response;

readonly class GetHazardousAsteroidsController
{
    public function __construct(
        private AsteroidService $asteroidService,
        private AsteroidPresenter $asteroidPresenter
    ) {
    }

    public function __invoke(): Response
    {
        // TODO implement pagination
        $asteroids = $this->asteroidService->getHazardousAsteroids();

        $result = array_map(fn(AsteroidEntity $asteroid) => $this->asteroidPresenter->present($asteroid), $asteroids);

        return new SuccessResponse($result);
    }
}
