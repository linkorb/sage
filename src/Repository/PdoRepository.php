<?php

namespace Sage\Repository;

use PDO;
use Sage\Sage;
use Sage\Exception;

class PdoRepository extends AbstractRepository implements RepositoryInterface
{
    public function __construct(Sage $sage, PDO $pdo, string $name)
    {
        $this->sage = $sage;
        $this->pdo = $pdo;
        $this->name = $name;
    }
    
    public function getRowsWhere(array $conditions = []): array
    {
        $where = $this->buildWhere($conditions);

        $sql = "SELECT * FROM " . $this->name;
        if ($where) {
            $sql .= ' WHERE ' . $where;
        }
        // echo $sql . PHP_EOL;

        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    protected function buildWhere(array $conditions = [])
    {
        $where = '';
        foreach ($conditions as $condition) {
            if ($where) {
                $where .= ' AND ';
            }
            $value = $condition->getValue();
            if (is_string($value)) {
                $value = '"' . $value . '"';
            }
            if (is_null($value)) {
                $value = 'NULL';
            }
            $where .= '(' . $condition->getFieldName() . $this->mapOperator($condition->getOperator()) . $value . ')';
        }
        return $where;
    }

    protected function mapOperator(string $operator): string
    {
        switch ($operator) {
            case '==':
                return '=';
            case 'IS': // for null comparisons
                return ' IS ';
            default:
                throw new Exception\UnsupportedOperatorException($operator);
        }
    }
}