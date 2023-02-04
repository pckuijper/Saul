<?php

declare(strict_types=1);

namespace Saul\Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Types\StringType;

/**
 * @template TType
 */
abstract class AbstractStringType extends StringType
{
    /** @use TypeTrait<TType> */
    use TypeTrait;
}
