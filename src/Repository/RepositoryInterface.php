<?php

namespace Sage\Repository;

interface RepositoryInterface
{
    public function getName(): string;
    
    public function findAll(array $conditions = []): array;
    public function findOne(array $conditions = []): Record;
}