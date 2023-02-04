<?php

declare(strict_types=1);

namespace Saul\Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * @template DomainObject
 */
trait TypeTrait
{
    /**
     * @return class-string<DomainObject>
     */
    abstract protected function getMappedClass(): string;

    /**
     * @param mixed $value
     *
     * @return DomainObject
     */
    abstract protected function getMappedClassInstance($value);

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        $value = parent::convertToPHPValue($value, $platform);

        if ($value === null) {
            return null;
        }

        return $this->getMappedClassInstance($value);
    }

    /**
     * @param AbstractPlatform $platform This needs to be here in order to comply to the Type class method signature
     *
     * @return mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null && $this->allowsNullValues()) {
            return null;
        }

        return $value;
    }

    /**
     * This is used to generate a DC2Type:<whatever_type> comment for the field
     * and allow doctrine diff to match the types instead of assuming
     * it's an integer type (id).
     *
     * The value outputted here is what is used as key in config/packages/doctrine.yaml:doctrine|dbal|types
     *
     * By convention, we use the canonical class name in snake case. If at some point we get a collision,
     * we can override this method in the collision type mapper.
     *
     * @return string
     *
     * NOTE: We can not have return type type hinted because it needs to be compatible with
     * Doctrine\DBAL\Types\Type::getName()
     */
    abstract public function getName();

    /**
     * @param AbstractPlatform $platform This needs to be here in order to comply to the Type class method signature
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    /**
     * In general an Enum is required and should have a value, but in some cases, because of Doctrine's implementation,
     * we cannot enforce this:.
     *
     * When we have a case of table inheritance, if we query an entity by the top table then Doctrine joins all the
     * inheritance tables and tries to hydrate all of their fields, including the ones from types
     * that don't belong to the entity we fetch for the database.
     *
     * This means that when we fetch a entity, doctrine will try to hydrate the sister entities fields as well,
     * and as we have enums in the sister entities, doctrine will try to create an enum for them. Of course
     * for the entity we care about this value will be NULL, so we need to do a null check in all Doctrine Enums
     * that we use in combination with a superclass.
     *
     * When we don't have a superclass (most cases) we should not allow null values.
     */
    protected function allowsNullValues(): bool
    {
        return false;
    }
}
