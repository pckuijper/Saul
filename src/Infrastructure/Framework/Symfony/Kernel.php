<?php

namespace Saul\Infrastructure\Framework\Symfony;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    private const ENV_PROD = 'prod';
    private const CONFIG_FILE_EXTENSIONS = '{yaml,php}';

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $configDir = $this->getConfigDir();

        $this->configurePackages($container, $configDir);
        $this->configureParameters($container, $configDir);
        $this->configureServices($container, $configDir);
    }

    private function getConfigDir(): string
    {
        return $this->getProjectDir() . '/config';
    }

    private function configurePackages(ContainerConfigurator $container, string $configDir): void
    {
        $container->import(sprintf('%s/{packages}/*.%s', $configDir, self::CONFIG_FILE_EXTENSIONS));
        $container->import(sprintf('%s/{packages}/%s/*.%s', $configDir, $this->getEnvironment(), self::CONFIG_FILE_EXTENSIONS));
    }

    private function configureParameters(ContainerConfigurator $container, string $configDir): void
    {
        $environmentList = array_unique([self::ENV_PROD, $this->getEnvironment()]);

        foreach ($environmentList as $environment) {
            $container->import(sprintf('%s/{parameters}/{%s}.%s', $configDir, $environment, self::CONFIG_FILE_EXTENSIONS));
            $container->import(sprintf('%s/{parameters}/{%s}/**/*.%s', $configDir, $environment, self::CONFIG_FILE_EXTENSIONS));
        }
    }

    private function configureServices(ContainerConfigurator $container, string $configDir): void
    {
        $environmentList = array_unique([self::ENV_PROD, $this->getEnvironment()]);

        foreach ($environmentList as $environment) {
            $container->import(sprintf('%s/{services}/{%s}.%s', $configDir, $environment, self::CONFIG_FILE_EXTENSIONS));
            $container->import(sprintf('%s/{services}/{%s}/**/*.%s', $configDir, $environment, self::CONFIG_FILE_EXTENSIONS));
        }
    }
}
