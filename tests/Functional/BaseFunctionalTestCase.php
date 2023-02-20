<?php

namespace Neo\Tests\Functional;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Neo\Tests\Fixtures\AsteroidFixtures;
use Neo\Tests\Utils\ApiUtils;
use Neo\Tests\Utils\ConsoleUtils;
use Neo\Tests\Utils\DatabaseUtils;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BaseFunctionalTestCase extends WebTestCase
{
    protected KernelBrowser $client;

    use ApiUtils;
    use ConsoleUtils;
    use DatabaseUtils;

    private static bool $isDatabaseAlreadyCreated = false;

    private static bool $isMigrationsAlreadyRun = false;

    protected bool $testNeedsFixtures = true;

    public function setUp(): void
    {
        $this->client = self::createClient();

        // TODO use approach where each test runs in transaction
        if ($this->testNeedsFixtures) {
            $this->recreateDatabase();
            $this->runMigrations();
            $this->loadFixtures();
        }
    }

    private function loadFixtures(): void
    {
        $em = $this->getEm();
        $loader = new Loader();
        foreach ($this->getFixtures() as $fixture) {
            $loader->addFixture($fixture);
        }

        $purger = new ORMPurger($em);
        $executor = new ORMExecutor($em, $purger);
        $executor->execute($loader->getFixtures());
    }

    /**
     * @return Fixture[]
     */
    private function getFixtures(): array
    {
        return [
            self::$kernel->getContainer()->get(AsteroidFixtures::class)
        ];
    }

    private function recreateDatabase(): void
    {
        if (!self::$isDatabaseAlreadyCreated) {
            $this->runCommand('doctrine:database:drop', [
                '--env' => 'test',
                '--force' => true,
                '--if-exists' => true,
            ]);
            $this->runCommand('doctrine:database:create', [
                '--env' => 'test',
            ]);
            self::$isDatabaseAlreadyCreated = true;
        }
    }

    private function runMigrations(): void
    {
        if (!self::$isMigrationsAlreadyRun) {
            $this->runCommand('doctrine:migrations:migrate', [
                '--env' => 'test',
                '--no-interaction' => true,
            ]);
            self::$isMigrationsAlreadyRun = true;
        }
    }
}

