<?php

namespace App\Service\Order\Invoice;


class InvoiceEntryCollection implements \Countable, \ArrayAccess, \IteratorAggregate
{

    /** @var InvoiceEntryInterface[]  */
    private array $entries = [];

    public function count(): int
    {
        return count($this->entries);
    }

    public function offsetExists($offset): bool
    {
        return isset($this->entries[$offset]);
    }

    public function offsetGet($offset): InvoiceEntryInterface
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

    public function add(InvoiceEntryInterface $entry): void
    {
        $this->entries[] = $entry;
    }

    public function remove(InvoiceEntryInterface $entry): bool
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