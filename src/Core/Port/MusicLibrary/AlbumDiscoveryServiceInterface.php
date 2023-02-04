<?php

declare(strict_types=1);

namespace Saul\Core\Port\MusicLibrary;

use Saul\Core\Component\MusicLibrary\Domain\Album;
use Saul\PhpExtension\Collection\Collection;

interface AlbumDiscoveryServiceInterface
{
    /**
     * @return Collection<Album>
     */
    public function findLatest(int $amountToFind): Collection;
}
