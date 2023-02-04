<?php

declare(strict_types=1);

namespace Saul\Core\Component\MusicLibrary\Domain;

use Saul\Core\SharedKernel\Component\MusicLibrary\AlbumId;

class Album
{
    private AlbumId $id;

    /**
     * @param Artist[] $artists
     */
    public function __construct(
        private ExternalAlbumId $externalAlbumId,
        private string $name,
        private ReleaseDate $releaseDate,
        private int $totalTracks,
        /** @var Artist[] */
        private array $artists
    ) {
        $this->id = new AlbumId();
    }

    public function getId(): AlbumId
    {
        return $this->id;
    }

    public function getExternalAlbumId(): ExternalAlbumId
    {
        return $this->externalAlbumId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getReleaseDate(): ReleaseDate
    {
        return $this->releaseDate;
    }

    public function getTotalTracks(): int
    {
        return $this->totalTracks;
    }

    /**
     * @return Artist[]
     */
    public function getArtists(): array
    {
        return $this->artists;
    }
}
