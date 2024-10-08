<?php

namespace App\ValueObject;

readonly class InputArgument
{
    public function __construct(private string $name, private mixed $value)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }
}
