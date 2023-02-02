<?php

declare(strict_types=1);

namespace Saul\Test\Testcase\TestFramework;

use ReflectionClass;
use Saul\Test\Framework\AbstractSaulTestcase;
use Saul\Test\Framework\InMemoryPersistenceService;
use Saul\Test\Testcase\TestFramework\Fixtures\DummyClass;

/**
 * @micro
 *
 * @small
 */
final class InMemoryPersistenceServiceTest extends AbstractSaulTestcase
{
    /**
     * @test
     */
    public function it_can_store_items(): void
    {
        $inMemoryPersistence = new InMemoryPersistenceService();

        $inMemoryPersistence->upsert(new DummyClass());
        $inMemoryPersistence->upsert(new DummyClass());

        $this->assertPersistenceContains($inMemoryPersistence, DummyClass::class, 2);
    }

    /**
     * @test
     */
    public function it_can_retrieve_collection_of_entities(): void
    {
        $inMemoryPersistence = new InMemoryPersistenceService();
        $inMemoryPersistence->upsert(new DummyClass());

        $collection = $inMemoryPersistence->findEntity(DummyClass::class);

        self::assertCount(1, $collection);
    }

    /**
     * @template TClassType of object
     *
     * @param class-string<TClassType> $type
     */
    private function assertPersistenceContains(object $object, string $type, int $amount): void
    {
        $class = new ReflectionClass($object);

        $property = $class->getProperty('entities');
        $property->setAccessible(true);

        /** @var array<class-string, TClassType[]> */
        $value = $property->getValue($object);

        self::assertTrue(array_key_exists($type, $value));
        self::assertCount($amount, $value[$type]);
    }
}
