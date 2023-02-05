<?php

declare(strict_types=1);

namespace Saul\Infrastructure\Persistence\Doctrine\Type;

use Exception;
use Saul\Core\SharedKernel\Component\MusicLibrary\ArtistId;

/**
 * @extends AbstractUlidIdType<ArtistId>
 */
final class ArtistIdType extends AbstractUlidIdType
{
    public function getName(): string
    {
        return 'artist_id';
    }

    protected function getMappedClass(): string
    {
        return ArtistId::class;
    }

    /**
     * @param mixed $value
     */
    protected function getMappedClassInstance($value): ArtistId
    {
        if (is_string($value) === false) {
            throw new Exception('Given value [' . var_export($value, true) . '] is not a string');
        }

        return new ArtistId($value);
    }
}
