<?php

namespace App\Service;

readonly class CurrencyRateCalculator
{
    public function __construct(private readonly CurrencyRate $currencyRate)
    {
    }

    public function convert(string $from, string $to, float $amount): float
    {
        return $amount * $this->currencyRate->getRate($from, $to);
    }
}
