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
}
