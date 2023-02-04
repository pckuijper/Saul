<?php

declare(strict_types=1);

namespace Saul\Core\Component\MusicLibrary\Domain;

final class ExternalArtistId
{
    public function __construct(
        public readonly string $id
    ) {
    }
}
