<?php

namespace Neo\Presentation\Presenter;

use Neo\Domain\ValueObject\BestMonth;

class BestMonthPresenter
{
    public function present(BestMonth $bestMonth): array
    {
        return [
            'monthNumber' => $bestMonth->getMonthNumber(),
            'monthFullName' => $bestMonth->getMonthFullName(),
            'asteroidsCount' => $bestMonth->getAsteroidsCount(),
        ];
    }
}
