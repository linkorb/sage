<?php

namespace Sage\Repository;

use Sage\Exception\UnsupportedOperatorException;
use Sage\Sage;

class ArrayRepository extends AbstractRepository implements RepositoryInterface
{
    public function __construct(
        protected Sage $sage,
        protected array $rows,
        protected string $name
    ) {
    }

    /**
     * @throws UnsupportedOperatorException
     */
    protected function getRowsWhere(array $conditions = []): array
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
