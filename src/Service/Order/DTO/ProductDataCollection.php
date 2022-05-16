<?php

namespace App\Service\Order\DTO;


class ProductDataCollection implements \Countable, \ArrayAccess, \IteratorAggregate
{

    /** @var ProductData[]  */
    private array $entries = [];

    public function count(): int
    {
        return count($this->entries);
    }

    public function offsetExists($offset): bool
    {
        return isset($this->entries[$offset]);
    }

    public function offsetSet($offset, $value): void
    {
        $this->entries[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->entries[$offset]);
    }

    public function add(ProductData $entry): void
    {
        $this->entries[] = $entry;
    }

    public function remove(ProductData $entry): bool
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

    public function getByProductId(string $productId): ?ProductData
    {
        $result = null;
        foreach ($this->entries as $object) {
            if ($object->getProductId() === $productId) {
                $result = $object;
                break;
            }
        }
        return $result;
    }

    public function offsetGet($offset): ProductData
    {
        return $this->entries[$offset];
    }

}