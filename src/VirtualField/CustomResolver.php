<?php

namespace Sage\VirtualField;

use Sage\Sage;
use Sage\Record;
use InvalidArgumentException;

class CustomResolver implements VirtualFieldInterface
{
    protected string $typeName;
    protected string $fieldName;
    protected $resolver;

    public function __construct(Sage $sage, string $fqfn, callable $resolver) {
        $part = explode('.', $fqfn);
        if (count($part)!=2) {
            throw new InvalidArgumentException($fqfn);
        }
        $this->typeName = $part[0];
        $this->fieldName = $part[1];
        $this->resolver = $resolver;
    }

    public function getTypeName(): string
    {
        return $this->typeName;
    }

    public function getFieldName(): string
    {
        return $this->fieldName;
    }

    public function resolve(Record $record)
    {
        $resolver = $this->resolver;
        return $resolver($record);
    }
}
