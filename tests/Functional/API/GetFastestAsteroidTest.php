<?php

namespace Neo\Tests\Functional\API;

use Neo\Domain\Entity\AsteroidEntity;
use Neo\Tests\Fixtures\AsteroidFixtures;
use Neo\Tests\Functional\BaseFunctionalTestCase;
use Symfony\Component\HttpFoundation\Response;

class GetFastestAsteroidTest extends BaseFunctionalTestCase
{
    /**
     * @test
     * @dataProvider fastestAndroidDataProvider
     */
    public function itReturnsFastestAsteroid(?bool $isHazardous, array $expectedFastedAsteroid): void
    {
        $parameters = [];
        if (isset($isHazardous)) {
            $parameters = ['hazardous' => var_export($isHazardous, true)];
        }

        $response = $this->apiRequest('GET', '/neo/fastest', $parameters);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $responseData = $this->decodeResponse($response);

        /** @var AsteroidEntity $expectedAsteroidEntity */
        $expectedAsteroidEntity = $this
            ->getOneBy(AsteroidEntity::class, ['referenceId' => $expectedFastedAsteroid['referenceId']]);
        $expectedFastedAsteroid += ['id' => $expectedAsteroidEntity->getId()];

        $this->assertEquals($expectedFastedAsteroid, $responseData['result']);
    }

    /**
     * @test
     */
    public function itReturnsNullWhenNoAsteroidsInDatabase(): void
    {
        $this->deleteAllObjects(AsteroidEntity::class);

        $response = $this->apiRequest('GET', '/neo/fastest');

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $responseData = $this->decodeResponse($response);

        $this->assertNull($responseData['result']);
    }

    /**
     * @test
     */
    public function itReturnsErrorWhenInvalidParametersArePassed(): void
    {
        $response = $this->apiRequest('GET', '/neo/fastest', ['hazardous' => 'WrongValue']);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $responseData = $this->decodeResponse($response);

        $this->assertEquals('"WrongValue" is invalid value for "hazardous" parameter', $responseData['error']);
    }

    public function fastestAndroidDataProvider(): array
    {
        return [
            'hazardousAsteroids' => [
                'isHazardous' => true,
                'expectedFastestAsteroid' => [
                    'name' => AsteroidFixtures::DATA[0]['name'],
                    'referenceId' => AsteroidFixtures::DATA[0]['referenceId'],
                    'date' => AsteroidFixtures::DATA[0]['date'],
                    'speed' => round(AsteroidFixtures::DATA[0]['speed'], 3),
                    'isHazardous' => true,
                ],
            ],
            'notHazardousAsteroids' => [
                'isHazardous' => false,
                'expectedFastestAsteroid' => [
                    'name' => AsteroidFixtures::DATA[5]['name'],
                    'referenceId' => AsteroidFixtures::DATA[5]['referenceId'],
                    'date' => AsteroidFixtures::DATA[5]['date'],
                    'speed' => round(AsteroidFixtures::DATA[5]['speed'], 3),
                    'isHazardous' => false,
                ]
            ],
            'hazardousParamIsNotPassed' => [
                'isHazardous' => null,
                'expectedFastestAsteroid' => [
                    'name' => AsteroidFixtures::DATA[5]['name'],
                    'referenceId' => AsteroidFixtures::DATA[5]['referenceId'],
                    'date' => AsteroidFixtures::DATA[5]['date'],
                    'speed' => round(AsteroidFixtures::DATA[5]['speed'], 3),
                    'isHazardous' => false,
                ]
            ],

        ];
    }
}
