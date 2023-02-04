<?php

declare(strict_types=1);

namespace Saul\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Saul\Core\Port\Persistence\PersistenceServiceInterface;
use Saul\PhpExtension\Collection\Collection;

final class DoctrinePersistenceService implements PersistenceServiceInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @template TClass of object
     *
     * @param class-string<TClass> $classFqcn
     *
     * @return Collection<TClass>
     */
    public function findEntity(string $classFqcn): Collection
    {
        /** @var EntityRepository<TClass> */
        $entityRepository = $this->entityManager->getRepository($classFqcn);

        $entities = $entityRepository->findAll();

        return new Collection($entities);
    }

    public function upsert(object $entity): void
    {
        $this->entityManager->persist($entity);
    }
}
