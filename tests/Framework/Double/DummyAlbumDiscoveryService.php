<?php

declare(strict_types=1);

namespace Saul\Test\Framework\Double;

use Saul\Core\Component\MusicLibrary\Domain\Album;
use Saul\Core\Port\MusicLibrary\AlbumDiscoveryServiceInterface;
use Saul\PhpExtension\Collection\Collection;

final class DummyAlbumDiscoveryService implements AlbumDiscoveryServiceInterface
{
    public function __construct(
        /** @var Collection<Album> */
        private Collection $albums
    ) {
    }

    public function findLatest(int $amountToFind): Collection
    {
        return $this->albums;
    }
}
