<?php

namespace Neo\Presentation\Filter;

use Neo\Domain\Filter\AsteroidFilter;
use Neo\Presentation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;

class AsteroidFilterFactory
{
    private const IS_HAZARDOUS_KEY = 'hazardous';

    public function fromRequest(Request $request): AsteroidFilter
    {
        if ($request->query->has(self::IS_HAZARDOUS_KEY)) {
            $isHazardous = $this->retrieveIsHazardousFromRequest($request);
        } else {
            $isHazardous = false;
        }

        return new AsteroidFilter($isHazardous);
    }

    private function retrieveIsHazardousFromRequest(Request $request): bool
    {
        $isHazardousStr = $request->query->get(static::IS_HAZARDOUS_KEY);
        $isHazardous = filter_var(
            $isHazardousStr,
            FILTER_VALIDATE_BOOLEAN,
            ['flags' => FILTER_NULL_ON_FAILURE]
        );

        if ($isHazardous === null) {
            throw new BadRequestException(
                sprintf('"%s" is invalid value for "%s" parameter', $isHazardousStr, self::IS_HAZARDOUS_KEY)
            );
        }

        return $isHazardous;
    }
}
