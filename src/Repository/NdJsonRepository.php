<?php

namespace Sage\Repository;

use Sage\Exception\UnsupportedOperatorException;
use Sage\Sage;
use RuntimeException;

class NdJsonRepository extends AbstractRepository implements RepositoryInterface
{
    public function __construct(
        private Sage $sage,
        private readonly string $filename,
        protected string $name
    )
    {
    }

    /**
     * @throws UnsupportedOperatorException
     */
    protected function getRowsWhere(array $conditions = []): array
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
