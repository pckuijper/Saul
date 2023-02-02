<?php

declare(strict_types=1);

namespace Saul\Core\Port\Persistence;

use Saul\PhpExtension\Collection\Collection;

interface PersistenceServiceInterface
{
    /**
     * @template TClass
     *
     * @param class-string<TClass> $classFqcn
     *
     * @return Collection<TClass>
     */
    public function findEntity(string $classFqcn): Collection;

    public function upsert(object $entity): void;
}
