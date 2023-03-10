<?php

declare(strict_types=1);

namespace Saul\Infrastructure\Persistence\Doctrine\Type;

use Exception;
use Saul\Core\SharedKernel\Component\MusicLibrary\AlbumId;

/**
 * @extends AbstractUlidIdType<AlbumId>
 */
final class AlbumIdType extends AbstractUlidIdType
{
    public function getName(): string
    {
        return 'album_id';
    }

    protected function getMappedClass(): string
    {
        return AlbumId::class;
    }

    /**
     * @param mixed $value
     */
    protected function getMappedClassInstance($value): AlbumId
    {
        if (is_string($value) === false) {
            throw new Exception('Given value [' . var_export($value, true) . '] is not a string');
        }

        return new AlbumId($value);
    }
}
