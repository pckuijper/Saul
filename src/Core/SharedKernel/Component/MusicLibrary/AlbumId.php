<?php

declare(strict_types=1);

namespace Saul\Core\SharedKernel\Component\MusicLibrary;

use Stringable;
use Symfony\Component\Uid\Ulid;

final class AlbumId implements Stringable
{
    public readonly string $id;

    public function __construct(string $ulid = null)
    {
        $this->id = $ulid ?? (string) new Ulid();
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
