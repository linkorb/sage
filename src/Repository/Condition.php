<?php

namespace Sage\Repository;

class Condition
{
    public function __construct(
        private readonly string $fieldName,
        private readonly string $operator,
        private $value
    )
    {
    }

    public function getFieldName(): string
    {
        return $this->fieldName;
    }

    public function getOperator(): string
    {
        return $this->operator;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->getFieldName() . $this->getOperator() . $this->getValue();
    }
}
