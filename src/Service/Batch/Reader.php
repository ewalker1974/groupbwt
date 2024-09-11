<?php

namespace App\Service\Batch;

use App\ValueObject\InputArgument;
use App\ValueObject\Transaction;

interface Reader
{
    public function open(InputArgument ...$inputArguments): void;

    public function hasMoreItems(): bool;

    public function readNext(): Transaction;

    public function close(): void;
}
