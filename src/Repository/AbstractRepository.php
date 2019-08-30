<?php

namespace Sage\Repository;

use Sage\Record;
use Sage\Exception;

abstract class AbstractRepository
{
    protected $name;
    
    public function getName(): string
    {
        return $this->name;
    }

    public function findAll(array $conditions = []): array
    {
        $rows = $this->getRowsWhere($conditions);
        return $this->rows2records($rows);
    }

    public function findOne(array $conditions = []): Record
    {
        $records = $this->findAll($conditions);
        if (count($records)==0) {
            throw new Exception\RecordNotFoundException($this->getName());
        }
        if (count($records)>1) {
            throw new Exception\RecordNotUniqueException($this->getName());
        }
        return $records[0];
    }

    public function rows2records(array $rows): array
    {
        $records = [];
        foreach ($rows as $row) {
            $record = new Record($this->sage, $this->getName(), $row);
            $records[] = $record;
        }
        return $records;
    }
}