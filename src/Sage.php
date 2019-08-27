<?php

namespace Sage;

use Sage\Repository\RepositoryInterface;
use Sage\VirtualField\VirtualFieldInterface;
use Sage\Exception;

class Sage
{
    protected $repositories = [];
    protected $virtualFields = [];

    public function addRepository(RepositoryInterface $repo)
    {
        $this->repositories[$repo->getName()] = $repo;
    }


    public function hasRepository(string $name): bool
    {
        return isset($this->repositories[$name]);
    }
    
    public function getRepository(string $name): RepositoryInterface
    {
        if (!$this->hasRepository($name)) {
            throw new Exception\RepositoryNotFoundException($name);
        }
        return $this->repositories[$name];
    }

    public function addVirtualField(VirtualFieldInterface $field)
    {
        $this->virtualFields[$field->getTypeName()][$field->getFieldName()] = $field;
    }

    public function hasVirtualField($typeName, $fieldName)
    {
        return isset($this->virtualFields[$typeName][$fieldName]);
    }

    public function getVirtualField($typeName, $fieldName)
    {
        if (!$this->hasVirtualField($typeName, $fieldName)) {
            throw new Exception\VirtualFieldNotFound($typeName . '.' , $fieldName);
        }
        return $this->virtualFields[$typeName][$fieldName];
    }
}