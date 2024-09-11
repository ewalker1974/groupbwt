<?php

namespace App\ValueObject\Impl;

use App\ValueObject\CommissionFee;

readonly class CommissionFeeImpl implements CommissionFee
{
    public function __construct(private float $value)
    {
    }

    #[\Override]
    public function getValue(): float
    {
        return $this->value;
    }

    #[\Override]
    public function getValueInString(): string
    {
        return sprintf('%.2f', $this->value);
    }
}
