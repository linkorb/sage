<?php

namespace Sage\Repository;

use Sage\Record;
use Sage\View;

interface RepositoryInterface
{
    public function getName(): string;

    public function getSchema(): array;
    public function setSchema(array $schema): void;

    public function getViews(): array;
    public function addView(View $view): void;

    
    public function findAll(array $conditions = []): array;
    public function findOne(array $conditions = []): Record;
}