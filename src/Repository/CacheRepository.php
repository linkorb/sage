<?php

namespace Sage\Repository;

use Sage\Sage;
use Psr\SimpleCache\CacheInterface;

class CacheRepository extends AbstractRepository implements RepositoryInterface
{
    public function __construct(
        protected Sage $sage,
        protected CacheInterface $cache,
        protected RepositoryInterface $repository,
        protected string $name
    ) {
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
