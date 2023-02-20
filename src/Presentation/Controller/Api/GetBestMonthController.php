<?php

namespace Neo\Presentation\Controller\Api;

use Neo\App\Service\AsteroidService;
use Neo\Domain\Exception\NoAsteroidsFoundException;
use Neo\Presentation\Filter\AsteroidFilterFactory;
use Neo\Presentation\Presenter\BestMonthPresenter;
use Neo\Presentation\Response\SuccessResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

readonly class GetBestMonthController
{
    public function __construct(
        private AsteroidService $asteroidService,
        private BestMonthPresenter $monthPresenter,
        private AsteroidFilterFactory $asteroidFilterFactory
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $asteroidFilter = $this->asteroidFilterFactory->fromRequest($request);
        try {
            $bestMonth = $this->asteroidService->getBestMonthInTheCurrentYear($asteroidFilter);
            $result = $this->monthPresenter->present($bestMonth);
        } catch (NoAsteroidsFoundException) {
            $result = null;
        }

        return new SuccessResponse($result);
    }
}
