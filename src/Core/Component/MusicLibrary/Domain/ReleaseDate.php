<?php

declare(strict_types=1);

namespace Saul\Core\Component\MusicLibrary\Domain;

use Saul\PhpExtension\DateTime\Date;
use Stringable;

final class ReleaseDate implements Stringable
{
    public readonly Date $date;

    public function __construct(string $releaseDate)
    {
        $this->date = new Date($releaseDate);
    }

    public function __toString(): string
    {
        return (string) $this->date;
    }
}
