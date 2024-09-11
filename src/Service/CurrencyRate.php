<?php

namespace App\Service;

interface CurrencyRate
{
    public function getRate(string $from, string $to): float;
}
