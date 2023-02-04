<?php

declare(strict_types=1);

namespace Saul\Core\Component\MusicLibrary\Domain;

use Stringable;

final class ExternalAlbumId implements Stringable
{
    public function __construct(
        public readonly string $id
    ) {
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
