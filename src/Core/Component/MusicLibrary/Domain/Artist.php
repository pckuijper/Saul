<?php

declare(strict_types=1);

namespace Saul\Core\Component\MusicLibrary\Domain;

use Saul\Core\SharedKernel\Component\MusicLibrary\ArtistId;

final class Artist
{
    private ArtistId $id;

    public function __construct(
        private ExternalArtistId $externalArtistId,
        private string $name
    ) {
        $this->id = new ArtistId();
    }

    public function getId(): ArtistId
    {
        return $this->id;
    }

    public function getExternalArtistId(): ExternalArtistId
    {
        return $this->externalArtistId;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
