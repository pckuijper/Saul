<?php

declare(strict_types=1);

namespace Saul\Test\Framework;

use Exception;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

final class TestApp
{
    public ContainerInterface $container;

    private KernelBrowser $client;
    private KernelInterface $kernel;
    private Application $cliApp;

    public function __construct()
    {
        $webTestCase = new class() extends WebTestCase {
            public function extractClient(): KernelBrowser
            {
                static::tearDown();

                return static::createClient();
            }
        };

        $this->client = $webTestCase->extractClient();
        $this->client->catchExceptions(true);
        $this->client->disableReboot();

        $this->container = $this->getContainer();
    }

    /**
     * @param array<string, string> $arguments
     * @param array<string, string> $inputs
     * @param array<string, string> $options
     */
    public function runCliCommand(
        string $commandName,
        array $arguments = [],
        array $inputs = [],
        array $options = []
    ): CommandOutput {
        $this->cliApp = $this->cliApp ?? new Application($this->getKernel());
        $commandTester = new CommandTester($this->cliApp->find($commandName));
        $commandTester->setInputs($inputs);
        $commandTester->execute($arguments, $options);

        return new CommandOutput(
            $commandTester->getStatusCode(),
            $commandTester->getDisplay()
        );
    }

    public function setContainerService(string $classFqcn, object $object): void
    {
        $this->container->set($classFqcn, $object);
    }

    private function getKernel(): KernelInterface
    {
        return $this->kernel ?? $this->kernel = $this->client->getKernel();
    }

    private function getContainer(): ContainerInterface
    {
        /** @var ?ContainerInterface */
        $container = $this->container
            ?? $this->client->getContainer()->get('test.service_container');

        if ($container === null) {
            throw new Exception();
        }

        return $this->container = $container;
    }
}
