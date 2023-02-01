<?php

declare(strict_types=1);

namespace Saul\PhpExtension\Test\Collection;

use Saul\PhpExtension\Collection\Collection;
use Saul\Test\Framework\AbstractSaulTestcase;

/**
 * @group micro
 *
 * @small
 */
final class CollectionTest extends AbstractSaulTestcase
{
    /**
     * @test
     */
    public function it_can_return_as_a_plain_array(): void
    {
        $expectedArray = ['a', 'b', 'c'];
        $collection = new Collection($expectedArray);

        self::assertSame(
            $expectedArray,
            $collection->toArray()
        );
    }

    /**
     * @test
     */
    public function it_can_be_counted(): void
    {
        $collection = new Collection([1, 2, 3]);
        self::assertCount(3, $collection);
    }

    /**
     * @test
     */
    public function it_can_be_turned_into_an_iterator(): void
    {
        $collection = new Collection([1, 2, 3]);
        self::assertTrue(is_iterable($collection));
    }
}
