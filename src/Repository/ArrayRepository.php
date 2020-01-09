<?php

namespace Sage\Repository;

use PDO;
use Sage\Sage;
use Sage\Exception;
use RuntimeException;

class ArrayRepository extends AbstractRepository implements RepositoryInterface
{
    public function __construct(Sage $sage, array $rows, string $name)
    {
        $this->sage = $sage;
        $this->rows = $rows;
        $this->name = $name;
    }
    
    public function getRowsWhere(array $conditions = []): array
    {
        $res = [];
        foreach ($this->rows as $row) {
            if ($this->match($row, $conditions)) {
                $res[] = $row;
            }
        }
        return $res;
    }
}
