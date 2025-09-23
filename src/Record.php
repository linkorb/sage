<?php

namespace Sage;

use ArrayAccess;
use Sage\Exception\FieldNotFoundException;
use Sage\Exception\VirtualFieldNotFoundException;

class Record implements ArrayAccess
{

    public function __construct(
        private readonly Sage $sage,
        private readonly string $typeName,
        private array $data
    ) {
    }

    public function offsetExists($offset): bool
    {
        if ($this->sage->hasVirtualField($this->typeName, $offset)) {
            return true;
        }
        if (array_key_exists($offset, $this->data)) {
            return true;
        }
        return false;
    }

    /**
     * @throws VirtualFieldNotFoundException
     * @throws FieldNotFoundException
     */
    public function offsetGet($offset): mixed
    {
        if ($this->sage->hasVirtualField($this->typeName, $offset)) {
            $field = $this->sage->getVirtualField($this->typeName, $offset);
            return $field->resolve($this);
        }
        if (array_key_exists($offset, $this->data)) {
            return $this->data[$offset];
        }
        throw new Exception\FieldNotFoundException($this->typeName . '.' . $offset);
    }

    public function offsetSet($offset, $value): void
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->data[$offset]);
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getKeys(): array
    {
        return array_keys($this->data);
    }
}
