<?php

namespace App\ValueObject;

use App\ValueObject\Impl\CommissionFeeImpl;

class SampleCommissionBuilder
{
    private float $value;

    public function getValue(): float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function build(): CommissionFee
    {
        return new CommissionFeeImpl($this->value);
    }
}
