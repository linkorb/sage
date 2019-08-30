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

    public function dump($data)
    {
        if (is_null($data)) {
            echo "#NULL#" . PHP_EOL;
            return;
        }
        if (is_a($data, Record::class)) {
            print_r($data->getData());
            return;
        }

        if (is_array($data)) {
            echo "ROWS: " . count($data) . PHP_EOL;
            foreach ($data as $row) {
                $this->dump($row);
            }
            return;
        }
        throw new RuntimeException("Unsupported input");
    }
}