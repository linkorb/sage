<?php

namespace Sage;

use Sage\Exception;
use ArrayAccess;

class Record implements ArrayAccess
{
    public function __construct(Sage $sage, string $typeName, $data)
    {
        $this->sage = $sage;
        $this->typeName = $typeName;
        $this->data = $data;
    }

    public function offsetExists($offset)
    {
        if ($this->sage->hasVirtualField($this->typeName, $offset)) {
            return true;
        }
        if (array_key_exists($offset, $this->data)) {
            return true;
        }
        return false;
    }

    public function offsetGet($offset)
    {
        if ($this->sage->hasVirtualField($this->typeName, $offset)) {
            $field = $this->sage->getVirtualField($this->typeName, $offset);
            return $field->resolve($this);
        }
        if (array_key_exists($offset, $this->data)) {
            return $this->data[$offset];
        }
        // echo "DATA:\n";
        // print_r($this->data);
        throw new Exception\FieldNotFoundException($this->typeName . '.' . $offset);
    }

    public function offsetSet($offset, $value)
    {
        throw new Exception\ImmutableException("set");
    }
    public function offsetUnset($offset)
    {
        throw new Exception\ImmutableException("unset");
    }
}