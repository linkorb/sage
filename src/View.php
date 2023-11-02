<?php

namespace Sage;

use Sage\Exception;

class View  
{
    protected $name;
    protected $label;
    protected $template;
    protected $default = false;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setLabel(?string $label): void
    {
        $this->label = $label;
    }

    public function getLabel(): string
    {
        return $this->label ?? $this->name;
    }


    public function setTemplate(string $template): void
    {
        $this->template = $template;
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function setDefault(bool $default): void
    {
        $this->default = $default;
    }

    public function getDefault(): bool
    {
        return $this->default;
    }

    
}