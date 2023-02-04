<?php

declare(strict_types=1);

namespace Saul\Test\Testcase\TestFramework\Double;

use Saul\Core\Component\MusicLibrary\Domain\Album;
use Saul\Core\Component\MusicLibrary\Domain\Artist;
use Saul\Core\Component\MusicLibrary\Domain\ExternalAlbumId;
use Saul\Core\Component\MusicLibrary\Domain\ExternalArtistId;
use Saul\Core\Component\MusicLibrary\Domain\ReleaseDate;
use Saul\PhpExtension\Collection\Collection;
use Saul\Test\Framework\AbstractSaulTestcase;
use Saul\Test\Framework\Double\DummyAlbumDiscoveryService;

/**
 * @small
 *
 * @micro
 */
final class DummyAlbumDiscoveryServiceTest extends AbstractSaulTestcase
{
    /**
     * @test
     */
    public function it_returns_given_collection_for_find_latest_method(): void
    {
        $collection = new Collection([$this->createAlbum()]);

        $dummyService = new DummyAlbumDiscoveryService($collection);

        self::assertSame($collection, $dummyService->findLatest(1));
    }

    private function createAlbum(): Album
    {
        return new Album(
            new ExternalAlbumId('external-id'),
            'Random name',
            new ReleaseDate('2022-02-01'),
            mt_rand(10, 20),
            [
                new Artist(
                    new ExternalArtistId('external-id'),
                    'Random name'
                ),
            ]
        );
    }
}
