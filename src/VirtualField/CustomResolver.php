<?php

namespace Sage\VirtualField;

use Sage\Sage;
use Sage\Record;
use InvalidArgumentException;

class CustomResolver implements VirtualFieldInterface
{
    protected $typeName;
    protected $fieldName;
    protected $resolver;

    public function __construct(Sage $sage, string $fqfn, callable $resolver)
    {
        $part = explode('.', $fqfn);
        if (count($part)!=2) {
            throw new InvalidArgumentException($fqfn);
        }
        $this->typeName = $part[0];
        $this->fieldName = $part[1];
        $this->resolver = $resolver;
    }

    public function getTypeName()
    {
        return $this->typeName;
    }

    public function getFieldName()
    {
        return $this->fieldName;
    }

    public function resolve(Record $record)
    {
        $resolver = $this->resolver;
        return $resolver($record);
    }
}