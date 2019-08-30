<?php

namespace Sage\Repository;

use PDO;
use Sage\Sage;
use Sage\Exception;
use RuntimeException;

class NdJsonRepository extends AbstractRepository implements RepositoryInterface
{
    public function __construct(Sage $sage, string $filename, string $name)
    {
        $this->sage = $sage;
        $this->filename = $filename;
        $this->name = $name;
    }
    
    public function getRowsWhere(array $conditions = []): array
    {
        $fp = fopen($this->filename, 'r');
        if (!$fp) {
            throw new RuntimeException("Can't open " . $this->filename);
        }
        $rows = [];
        while (($line = fgets($fp)) !== false) {
            $row = json_decode($line, true);
            if ($this->match($row, $conditions)) {
                $rows[] = $row;
            }
        }
        fclose($fp);
        return $rows;
    }

    protected function match(array $row, array $conditions = []): bool
    {
        $match = true;
        foreach ($conditions as $condition) {
            $value = $condition->getValue();
            $fieldValue = $row[$condition->getFieldName()];
            switch ($condition->getOperator()) {
                case '==':
                    if ($fieldValue == $value) {
                        // ok
                    } else {
                        $match = false;
                    }
                    break;
                default:
                    throw new RuntimeException("Unsupported operator");
                    break;
            }
        }
        return $match;
    }
}
