<?php

declare(strict_types=1);

use Saul\Core\Port\Persistence\PersistenceServiceInterface;
use Saul\Infrastructure\Persistence\Doctrine\DoctrinePersistenceService;
use Saul\Test\Framework\InMemoryPersistenceService;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $container): void {
    $services = $container
        ->services()
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();

    $services->set(PersistenceServiceInterface::class, InMemoryPersistenceService::class);
    $services->set(DoctrinePersistenceService::class);
};
