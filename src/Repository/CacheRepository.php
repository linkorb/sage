<?php

namespace Sage\Repository;

use PDO;
use Sage\Sage;
use Sage\Exception;
use RuntimeException;
use Psr\SimpleCache\CacheInterface;

class CacheRepository extends AbstractRepository implements RepositoryInterface
{
    protected $name;
    protected $sage;
    protected $cache;
    protected $repository;

    public function __construct(Sage $sage, CacheInterface $cache, RepositoryInterface $repository, string $name)
    {
        $this->sage = $sage;
        $this->cache = $cache;
        $this->repository = $repository;
        $this->name = $name;
    }
    
    protected function getRowsWhere(array $conditions = []): array
    {
        $cacheKey = 'repository:' . $this->getName();
        foreach ($conditions as $condition) {
            $cacheKey .= '@condition:' . (string)$condition;
        }
        $cacheKey = sha1($cacheKey);
        if ($this->cache->has($cacheKey)) {
            $rows = $this->cache->get($cacheKey);
        } else {
            $rows = $this->repository->getRowsWhere($conditions);
            $this->cache->set($cacheKey, $rows);
        }
        return $rows;
    }
}
