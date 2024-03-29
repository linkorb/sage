<?php

namespace Sage\Repository;

use Sage\Record;
use Sage\View;
use Sage\Exception;

abstract class AbstractRepository
{
    protected $name;
    protected $schema;
    protected $views = [];
    
    public function getName(): string
    {
        return $this->name;
    }

    public function getSchema(): array
    {
        return $this->schema;
    }

    public function setSchema(array $schema): void
    {
        $this->schema = $schema;
    }

    abstract protected function getRowsWhere(array $conditions = []): array;

    public function findAll(array $conditions = []): array
    {
        $rows = $this->getRowsWhere($conditions);
        return $this->rows2records($rows);
    }

    public function findOne(array $conditions = []): Record
    {
        $records = $this->findAll($conditions);
        if (count($records)==0) {
            $conditionsText = '';
            foreach ($conditions as $condition) {
                $conditionsText .= (string)$condition . ' ';
            }
            throw new Exception\RecordNotFoundException($this->getName() . ': ' . $conditionsText);
        }
        if (count($records)>1) {
            throw new Exception\RecordNotUniqueException($this->getName());
        }
        return $records[0];
    }

    protected function rows2records(array $rows): array
    {
        $records = [];
        foreach ($rows as $row) {
            $record = new Record($this->sage, $this->getName(), $row);
            $records[] = $record;
        }
        return $records;
    }

    protected function match(array $row, array $conditions = []): bool
    {
        $match = true;
        foreach ($conditions as $condition) {
            $value = (string)trim($condition->getValue());
            $fieldValue = (string)trim($row[$condition->getFieldName()] ?? null);
            switch ($condition->getOperator()) {
                case '==':
                    if ($fieldValue == $value) {
                        // ok
                    } else {
                        $match = false;
                    }
                    break;
                case '!=':
                    if ($fieldValue != $value) {
                        // ok
                    } else {
                        $match = false;
                    }
                    break;
                default:
                    throw new Exception\UnsupportedOperatorException("Unsupported operator " . $condition->getOperator());
                    break;
            }
        }
        return $match;
    }


    public function getViews(): array
    {
        return $this->views;
    }

    public function addView(View $view): void
    {
        $this->views[$view->getName()] = $view;
    }


}