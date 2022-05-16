<?php

namespace App\Service\Order\DTO;


class OrderPlacementProductCollection implements \Countable, \ArrayAccess, \IteratorAggregate
{

    /** @var OrderPlacementProduct[]  */
    private array $entries = [];

    public function count(): int
    {
        return count($this->entries);
    }

    public function offsetExists($offset): bool
    {
        return isset($this->entries[$offset]);
    }

    public function offsetGet($offset): OrderPlacementProduct
    {
        return $this->entries[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        $this->entries[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->entries[$offset]);
    }

    public function add(OrderPlacementProduct $entry): void
    {
        $this->entries[] = $entry;
    }

    public function remove(OrderPlacementProduct $entry): bool
    {
        $key = array_search($entry, $this->entries);
        if ($key === false) {
            return false;
        }
        unset($this->entries[$key]);
        return true;
    }

    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->entries);
    }

}