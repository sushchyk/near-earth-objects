<?php

namespace Neo\Infra\Persistence\Doctrine\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Neo\Domain\Builder\AsteroidBuilder;

class AppFixtures extends Fixture
{
    private const ASTEROIDS_COUNT = 1000;

    private AsteroidBuilder $asteroidBuilder;

    public function __construct(AsteroidBuilder $asteroidBuilder)
    {
        $this->asteroidBuilder = $asteroidBuilder;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::ASTEROIDS_COUNT; $i++) {
            $referenceId = 1000 + $i;
            $name = sprintf('%d %s', $referenceId, $faker->name());
            $date =  \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-3 years', 'now'));
            $speed = $faker->randomFloat(3, 1000, 100000);
            $isHazardous = $faker->boolean;

            $asteroid = $this->asteroidBuilder
                ->setName($name)
                ->setReferenceId((string) $referenceId)
                ->setDate($date)
                ->setSpeed($speed)
                ->setIsHazardous($isHazardous)
                ->build();

            $manager->persist($asteroid);
        }

        $manager->flush();
    }
}
