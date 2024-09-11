<?php

namespace App\ValueObject;

interface Transaction
{
    public function getCard(): string;

    public function getAmount(): float;

    public function getCurrency(): string;
}
