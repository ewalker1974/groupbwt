<?php

namespace App\Service\Batch;

use App\ValueObject\InputArgument;

class BatchInputArguments
{
    /** @var array<string, InputArgument> */
    private array $arguments = [];

    public function setArgument(string $name, mixed $value): void
    {
        $this->arguments[$name] = new InputArgument($name, $value);
    }

    public function getArguments(): array
    {
        return array_values($this->arguments);
    }
}
