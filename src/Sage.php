<?php

namespace Sage;

use Sage\Exception\RepositoryNotFoundException;
use Sage\Exception\VirtualFieldNotFoundException;
use Sage\Repository\RepositoryInterface;
use Sage\VirtualField\VirtualFieldInterface;

class Sage
{
    protected $name;
    protected $title;
    protected $about;

    protected array $repositories = [];
    protected array $virtualFields = [];

    public function addRepository(RepositoryInterface $repo): void
    {
        $this->repositories[$repo->getName()] = $repo;
    }


    public function hasRepository(string $name): bool
    {
        return isset($this->repositories[$name]);
    }

    public function getRepositories(): array
    {
        return $this->repositories;
    }

    /**
     * @throws RepositoryNotFoundException
     */
    public function getRepository(string $name): RepositoryInterface
    {
        if (!$this->hasRepository($name)) {
            throw new Exception\RepositoryNotFoundException($name);
        }
        return $this->repositories[$name];
    }

    public function addVirtualField(VirtualFieldInterface $field): void
    {
        $this->virtualFields[$field->getTypeName()][$field->getFieldName()] = $field;
    }

    public function hasVirtualField($typeName, $fieldName): bool
    {
        return isset($this->virtualFields[$typeName][$fieldName]);
    }

    public function getVirtualField($typeName, $fieldName)
    {
        if (!$this->hasVirtualField($typeName, $fieldName)) {
            throw new VirtualFieldNotFoundException($typeName . '.' , $fieldName);
        }
        return $this->virtualFields[$typeName][$fieldName];
    }

    public function dump($data): void
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
        throw new \RuntimeException("Unsupported input");
    }



    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Sage
    {
        $this->name = $name;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Sage
    {
        $this->title = $title;
        return $this;
    }

    public function getAbout(): string
    {
        return $this->about;
    }

    public function setAbout(string $about): Sage
    {
        $this->about = $about;
        return $this;
    }


}
