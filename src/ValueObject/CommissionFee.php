<?php

namespace App\ValueObject;

interface CommissionFee
{
    public function getValue(): float;

    public function getValueInString(): string;
}
