<?php

namespace Neo\Tests\Functional\API;
use Neo\Domain\Entity\AsteroidEntity;
use Neo\Tests\Fixtures\AsteroidFixtures;
use Neo\Tests\Functional\BaseFunctionalTestCase;

class GetHazardousAsteroidsTest extends BaseFunctionalTestCase
{
    /** @test */
    public function itReturnsListOfHazardousAsteroids(): void
    {
        $response = $this->apiRequest('GET', '/neo/hazardous', []);

        $this->assertEquals(200, $response->getStatusCode());

        $responseData = $this->decodeResponse($response);
        $this->assertCount(5, $responseData['result']);

        $this->assertAsteroidEquals(AsteroidFixtures::DATA[4], $responseData['result'][0]);
        $this->assertAsteroidEquals(AsteroidFixtures::DATA[0], $responseData['result'][1]);
        $this->assertAsteroidEquals(AsteroidFixtures::DATA[1], $responseData['result'][2]);
        $this->assertAsteroidEquals(AsteroidFixtures::DATA[2], $responseData['result'][3]);
        $this->assertAsteroidEquals(AsteroidFixtures::DATA[3], $responseData['result'][4]);

    }

    private function assertAsteroidEquals(array $expectedAsteroidData, array $actualAsteroid): void
    {
        /** @var AsteroidEntity $expectedAsteroidEntity */
        $expectedAsteroidEntity = $this
            ->getOneBy(AsteroidEntity::class, ['referenceId' => $expectedAsteroidData['referenceId']]);
        $expectedAsteroidData += ['id' => $expectedAsteroidEntity->getId()];


        $this->assertEquals($expectedAsteroidData, $actualAsteroid);
    }
}
