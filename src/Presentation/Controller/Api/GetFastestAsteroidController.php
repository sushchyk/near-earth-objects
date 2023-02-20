<?php

namespace Neo\Presentation\Controller\Api;

use Neo\App\Service\AsteroidService;
use Neo\Domain\Exception\NoAsteroidsFoundException;
use Neo\Presentation\Filter\AsteroidFilterFactory;
use Neo\Presentation\Presenter\AsteroidPresenter;
use Neo\Presentation\Response\SuccessResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

readonly class GetFastestAsteroidController
{
    public function __construct(
        private AsteroidService $asteroidService,
        private AsteroidPresenter $asteroidPresenter,
        private AsteroidFilterFactory $asteroidFilterFactory
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $asteroidFilter = $this->asteroidFilterFactory->fromRequest($request);
        try {
            $fastestAsteroid = $this->asteroidService->getFastestAsteroid($asteroidFilter);
            $result = $this->asteroidPresenter->present($fastestAsteroid);
        } catch (NoAsteroidsFoundException) {
            $result = null;
        }

        return new SuccessResponse($result);
    }
}
