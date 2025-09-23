<?php

namespace Sage\VirtualField;

use Sage\Exception\RepositoryNotFoundException;
use Sage\Sage;
use Sage\Record;
use Sage\Repository\Condition;

class OneToMany implements VirtualFieldInterface
{
    private string $typeName;
    private string $fieldName;
    private string $remoteTypeName;
    private string $remoteFieldName;

    public function __construct(
        private readonly Sage $sage,
        string $fqfn,
        private readonly string $localKey,
        string $remoteFqfn
    ) {
        $part = explode('.', $fqfn);
        if (count($part)!=2) {
            throw new \InvalidArgumentException($fqfn);
        }
        $this->typeName = $part[0];
        $this->fieldName = $part[1];

        $part = explode('.', $remoteFqfn);
        if (count($part)!=2) {
            throw new \InvalidArgumentException($remoteFqfn);
        }
        $this->remoteTypeName = $part[0];
        $this->remoteFieldName = $part[1];
    }

    public function getTypeName(): string
    {
        return $this->typeName;
    }
    public function getFieldName(): string
    {
        return $this->fieldName;
    }

    /**
     * @throws RepositoryNotFoundException
     */
    public function resolve(Record $record): ?array
    {
        $remoteRepo = $this->sage->getRepository($this->remoteTypeName);

        if (!isset($record[$this->localKey])) {
            return null;
        }

        $records = $remoteRepo->findAll([new Condition($this->remoteFieldName, '==', $record[$this->localKey])]);
        return $records;
    }
}
