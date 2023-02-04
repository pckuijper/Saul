<?php

declare(strict_types=1);

namespace Saul\Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Exception;
use Saul\Core\SharedKernel\Component\MusicLibrary\AlbumId;

final class AlbumIdType extends StringType
{
    /** @use TypeTrait<AlbumId> */
    use TypeTrait;

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

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        $column['length'] = 26;
        $column['fixed'] = true;

        return $platform->getStringTypeDeclarationSQL($column);
    }
}
