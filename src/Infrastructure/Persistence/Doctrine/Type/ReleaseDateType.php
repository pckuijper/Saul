<?php

declare(strict_types=1);

namespace Saul\Infrastructure\Persistence\Doctrine\Type;

use Saul\Core\Component\MusicLibrary\Domain\ReleaseDate;

/**
 * @extends AbstractStringType<ReleaseDate>
 */
final class ReleaseDateType extends AbstractStringType
{
    public function getName(): string
    {
        return 'release_date';
    }

    protected function getMappedClass(): string
    {
        return ReleaseDate::class;
    }

    /**
     * @param string $value
     */
    protected function getMappedClassInstance($value): ReleaseDate
    {
        return new ReleaseDate($value);
    }
}
