<?php

namespace Sage\VirtualField;

use Sage\Record;

interface VirtualFieldInterface
{
    public function getTypeName();
    public function getFieldName();
    public function resolve(Record $record);
}