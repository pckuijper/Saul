<?php

declare(strict_types=1);

namespace Saul\Test\Testcase\Presentation\Console\Album;

use Saul\Core\Component\MusicLibrary\Domain\Album;
use Saul\Core\Component\MusicLibrary\Domain\Artist;
use Saul\Core\Component\MusicLibrary\Domain\ExternalAlbumId;
use Saul\Core\Component\MusicLibrary\Domain\ExternalArtistId;
use Saul\Core\Component\MusicLibrary\Domain\ReleaseDate;
use Saul\Core\Port\MusicLibrary\AlbumDiscoveryServiceInterface;
use Saul\Core\Port\Persistence\PersistenceServiceInterface;
use Saul\PhpExtension\Collection\Collection;
use Saul\Test\Framework\AbstractSaulTestcase;
use Saul\Test\Framework\Double\DummyAlbumDiscoveryService;
use Saul\Test\Framework\InMemoryPersistenceService;
use Saul\Test\Framework\TestApp;
use Symfony\Component\Console\Command\Command;

/**
 * @small
 */
final class FindLatestAlbumsTest extends AbstractSaulTestcase
{
    private const COMMAND_NAME = 'saul:album:find-latest';

    private TestApp $testApp;

    protected function setUp(): void
    {
        $this->testApp = new TestApp();
    }

    /**
     * @test
     */
    public function it_stores_found_albums_in_the_persistence_layer(): void
    {
        $albumDiscovery = new DummyAlbumDiscoveryService(
            new Collection([
                $this->createAlbum(),
                $this->createAlbum(),
                $this->createAlbum(),
            ])
        );
        $persistence = new InMemoryPersistenceService();

        $this->testApp->setContainerService(AlbumDiscoveryServiceInterface::class, $albumDiscovery);
        $this->testApp->setContainerService(PersistenceServiceInterface::class, $persistence);

        $expectedAlbums = 3;
        $this->testApp->runCliCommand(
            self::COMMAND_NAME,
            [
                '--amount' => (string) $expectedAlbums,
            ]
        );

        self::assertCount(
            $expectedAlbums,
            $persistence->findEntity(Album::class)
        );
    }

    /**
     * @test
     */
    public function it_returns_an_error_when_invalid_amount_is_specified(): void
    {
        $result = $this->testApp->runCliCommand(
            self::COMMAND_NAME,
            [
                '--amount' => 'NOT_A_NUMBER',
            ]
        );

        self::assertSame(Command::FAILURE, $result->statusCode);
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
