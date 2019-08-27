<?php

namespace Sage\Repository;

use Sage\Record;

abstract class AbstractRepository
{
    public function findAll(array $conditions = []): array
    {
        $rows = $this->getRowsWhere($conditions);
        return $this->rows2records($rows);
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