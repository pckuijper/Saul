<?php

declare(strict_types=1);

namespace Saul\Test\Framework;

use Saul\Core\Port\Persistence\PersistenceServiceInterface;
use Saul\PhpExtension\Collection\Collection;

final class InMemoryPersistenceService implements PersistenceServiceInterface
{
    /** @var array<class-string, object[]> */
    private array $entities;

    /**
     * @template TClass of object
     *
     * @param class-string<TClass> $classFqcn
     *
     * @return Collection<TClass>
     */
    public function findEntity(string $classFqcn): Collection
    {
        /** @var TClass[] */
        $entities = $this->entities[$classFqcn] ?? [];

        return new Collection($entities);
    }

    /**
     * @template TEntityClass of object
     *
     * @param TEntityClass $entity
     */
    public function upsert(object $entity): void
    {
        $this->entities[get_class($entity)][] = $entity;
    }
}
