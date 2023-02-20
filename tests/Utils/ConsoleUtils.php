<?php

namespace Neo\Tests\Utils;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

trait ConsoleUtils
{
    protected function runCommand(string $commandName, array $input): void
    {
        $application = new Application(static::$kernel);

        $command = $application->find($commandName);
        $commandTester = new CommandTester($command);
        $statusCode = $commandTester->execute($input);
        if ($statusCode !== 0) {

            throw new \RuntimeException(sprintf("Running of console command '%s' failed. Returned code is %d. Output:\n%s", $commandName, $statusCode, $commandTester->getDisplay()));
        }
    }
}
