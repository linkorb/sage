<?php

namespace Sage\VirtualField;

use Sage\Sage;
use Sage\Record;
use Sage\Repository\Condition;

class ManyToOne implements VirtualFieldInterface
{
    /**
     * @var Sage
     */
    private $sage;

    /**
     * @var mixed|string
     */
    private $typeName;

    /**
     * @var mixed|string
     */
    private $fieldName;

    /**
     * @var string
     */
    private $localKey;

    /**
     * @var mixed|string
     */
    private $remoteTypeName;

    /**
     * @var mixed|string
     */
    private $remoteFieldName;

    public function __construct(Sage $sage, string $fqfn, string $localKey, string $remoteFqfn)
    {
        $this->sage = $sage;

        $part = explode('.', $fqfn);
        if (count($part)!=2) {
            throw new InvalidArgumentException($fqfn);
        }
        $this->typeName = $part[0];
        $this->fieldName = $part[1];

        $this->localKey = $localKey;

        $part = explode('.', $remoteFqfn);
        if (count($part)!=2) {
            throw new InvalidArgumentException($remoteFqfn);
        }
        $this->remoteTypeName = $part[0];
        $this->remoteFieldName = $part[1];
    }

    public function getTypeName()
    {
        return $this->typeName;
    }
    
    public function getFieldName()
    {
        return $this->fieldName;
    }

    public function resolve(Record $record)
    {
        $remoteRepo = $this->sage->getRepository($this->remoteTypeName);

        if (!isset($record[$this->localKey])) {
            return null;
        }

        $records = $remoteRepo->findAll([new Condition($this->remoteFieldName, '==', $record[$this->localKey])]);
        if (count($records)>0) {
            return $records[0];
        }
        return null;
    }
}