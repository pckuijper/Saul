<?php

declare(strict_types=1);

namespace Saul\Infrastructure\Persistence\Doctrine\Type;

use Saul\Core\Component\MusicLibrary\Domain\ExternalAlbumId;

/**
 * @extends AbstractStringType<ExternalAlbumId>
 */
final class ExternalAlbumIdType extends AbstractStringType
{
    public function getName(): string
    {
        return 'external_album_id';
    }

    protected function getMappedClass(): string
    {
        return ExternalAlbumId::class;
    }

    /**
     * @param string $value
     */
    protected function getMappedClassInstance($value): ExternalAlbumId
    {
        return new ExternalAlbumId($value);
    }
}
