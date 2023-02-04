<?php

declare(strict_types=1);

namespace Saul\Core\SharedKernel\Component\MusicLibrary;

use Symfony\Component\Uid\Ulid;

final class AlbumId
{
    public function __construct(
        public readonly Ulid $id = new Ulid()
    ) {
    }
}
