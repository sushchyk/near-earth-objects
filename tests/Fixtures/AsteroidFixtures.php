<?php

namespace Neo\Tests\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Neo\Domain\Builder\AsteroidBuilder;

class AsteroidFixtures extends Fixture
{
    private AsteroidBuilder $asteroidBuilder;

    public function __construct(AsteroidBuilder $asteroidBuilder)
    {
        $this->asteroidBuilder = $asteroidBuilder;
    }

    public const DATA = [
        0 => [
            'referenceId' => '2001',
            'date' => '2023-02-28',
            'name' => '2001 Einstein',
            'speed' => 71099.326,
            'isHazardous' => true
        ],
        1 => [
            'referenceId' => '2002',
            'date' => '2023-02-28',
            'name' => '2002 Euler',
            'speed' => 65260.573,
            'isHazardous' => true
        ],
        2 => [
            'referenceId' => '6765',
            'date' => '2022-03-30',
            'name' => '6765 Fibonacci',
            'speed' => 4187.103,
            'isHazardous' => true
        ],
        3 => [
            'referenceId' => '7000',
            'date' => '2022-03-30',
            'name' => '7000 Curie',
            'speed' => 31548.721,
            'isHazardous' => true
        ],
        4 => [
            'referenceId' => '7672',
            'date' => '2023-03-30',
            'name' => '7672 Hawking',
            'speed' => 12661.061,
            'isHazardous' => true
        ],
        5 => [
            'referenceId' => '8000',
            'date' => '2023-01-31',
            'name' => '8000 Isaac Newton',
            'speed' => 26178.340,
            'isHazardous' => false
        ],
        6 => [
            'referenceId' => '13092',
            'date' => '2023-02-28',
            'name' => '13092 Schrödinger',
            'speed' => 15614.119,
            'isHazardous' => false
        ],
        7 =>  [
            'referenceId' => '13149',
            'date' => '2023-03-30',
            'name' => '13149 Heisenberg',
            'speed' => 6027.454,
            'isHazardous' => false
        ]
    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::DATA as $asteroidData) {
            $this->asteroidBuilder->setName($asteroidData['name'])
                                    ->setReferenceId($asteroidData['referenceId'])
                                    ->setDate(new \DateTimeImmutable($asteroidData['date']))
                                    ->setSpeed($asteroidData['speed'])
                                    ->setIsHazardous($asteroidData['isHazardous']);
            $asteroidEntity = $this->asteroidBuilder->build();
            $manager->persist($asteroidEntity);
        }

        $manager->flush();
    }
}
