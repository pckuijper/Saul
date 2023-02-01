<?php

declare(strict_types=1);

namespace Saul\PhpExtension\Collection;

use ArrayIterator;
use Countable;
use Iterator;
use IteratorAggregate;

/**
 * @template TValue
 *
 * @implements IteratorAggregate<array-key, TValue>
 */
final class Collection implements Countable, IteratorAggregate
{
    /** @var array<array-key, TValue> */
    private array $items = [];

    /**
     * @param array<array-key, TValue> $items
     */
    public function __construct(mixed $items = [])
    {
        $this->items = $items;
    }

    /**
     * @return array<array-key, TValue>
     */
    public function toArray(): array
    {
        return $this->items;
    }

    /**
     * @return Iterator<array-key, TValue>
     */
    public function getIterator(): Iterator
    {
        return new ArrayIterator($this->items);
    }

    public function count(): int
    {
        return count($this->items);
    }
}
