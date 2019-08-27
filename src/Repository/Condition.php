<?php

namespace Sage\Repository;

class Condition
{
    public function __construct(string $fieldName, $operator, $value)
    {
        $this->fieldName = $fieldName;
        $this->operator = $operator;
        $this->value = $value;
    }

    public function getFieldName(): string
    {
        return $this->fieldName;
    }

    public function getOperator()
    {
        return $this->operator;
    }

    public function getValue()
    {
        return $this->value;
    }
    
}