<?php

namespace Sage;

class View
{
    public function __construct(
        protected string $name,
        protected ?string $label = null,
        protected ?string $template = null,
        protected bool $default = false,
    )
    {
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
