<?php

declare(strict_types=1);

namespace Saul\Infrastructure\Persistence\Doctrine\Type;

use Saul\Core\Component\MusicLibrary\Domain\ExternalArtistId;

/**
 * @extends AbstractStringType<ExternalArtistId>
 */
final class ExternalArtistIdType extends AbstractStringType
{
    public function getName(): string
    {
        return 'external_artist_id';
    }

    protected function getMappedClass(): string
    {
        return ExternalArtistId::class;
    }

    /**
     * @param string $value
     */
    protected function getMappedClassInstance($value): ExternalArtistId
    {
        return new ExternalArtistId($value);
    }
}
