<?php

declare(strict_types=1);

namespace Saul\Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

/**
 * @template TIdClass
 */
abstract class AbstractUlidIdType extends StringType
{
    /** @use TypeTrait<TIdClass> */
    use TypeTrait;

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        $column['length'] = 26;
        $column['fixed'] = true;

        return $platform->getStringTypeDeclarationSQL($column);
    }
}
