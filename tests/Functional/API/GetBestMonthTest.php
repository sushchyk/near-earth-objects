<?php

namespace Neo\Tests\Functional\API;

use Neo\Domain\Entity\AsteroidEntity;
use Neo\Tests\Functional\BaseFunctionalTestCase;
use Symfony\Component\HttpFoundation\Response;

class GetBestMonthTest extends BaseFunctionalTestCase
{
    /**
     * @test
     * @dataProvider bestMonthDataProvider
     */
    public function itReturnsBestMonth(?bool $isHazardous, array $expectedBestMonth): void
    {
        $parameters = [];
        if (isset($isHazardous)) {
            $parameters = ['hazardous' => var_export($isHazardous, true)];
        }

        $response = $this->apiRequest('GET', '/neo/best-month', $parameters);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $responseData = $this->decodeResponse($response);

        $this->assertEquals($expectedBestMonth ,$responseData['result']);
    }

    /**
     * @test
     */
    public function itReturnsNullWhenNoAsteroidsInDatabase(): void
    {
        $this->deleteAllObjects(AsteroidEntity::class);

        $response = $this->apiRequest('GET', '/neo/best-month');

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $responseData = $this->decodeResponse($response);

        $this->assertNull($responseData['result']);
    }

    /**
     * @test
     */
    public function itReturnsErrorWhenInvalidParametersArePassed(): void
    {
        $response = $this->apiRequest('GET', '/neo/best-month', ['hazardous' => 'WrongValue']);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $responseData = $this->decodeResponse($response);

        $this->assertEquals('"WrongValue" is invalid value for "hazardous" parameter', $responseData['error']);
    }

    public function bestMonthDataProvider(): array
    {
        return [
            'hazardousAsteroids' => [
                'isHazardous' => true,
                'expectedBestMonth' => [
                    'monthNumber' => 2,
                    'monthFullName' => 'February',
                    'asteroidsCount' => 2,
                ],
            ],
            'notHazardousAsteroids' => [
                'isHazardous' => false,
                'expectedBestMonth' => [
                    'monthNumber' => 3,
                    'monthFullName' => 'March',
                    'asteroidsCount' => 1,
                ]
            ],
            'hazardousIsNotPassed' => [
                'isHazardous' => null,
                'expectedBestMonth' => [
                    'monthNumber' => 3,
                    'monthFullName' => 'March',
                    'asteroidsCount' => 1,
                ]
            ],
        ];
    }
}
