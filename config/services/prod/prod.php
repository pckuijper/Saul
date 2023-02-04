<?php

declare(strict_types=1);

use Saul\Core\Port\MusicLibrary\AlbumDiscoveryServiceInterface;
use Saul\Core\Port\Persistence\PersistenceServiceInterface;
use Saul\Infrastructure\MusicLibrary\Spotify\SpotifyAlbumDiscoveryService;
use Saul\Infrastructure\Persistence\Doctrine\DoctrinePersistenceService;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $container): void {
    $services = $container
        ->services()
        ->defaults()
        ->autowire()
        ->autoconfigure();

    $services->set(PersistenceServiceInterface::class, DoctrinePersistenceService::class);

    $services->set(AlbumDiscoveryServiceInterface::class, SpotifyAlbumDiscoveryService::class)
        ->public();
};
