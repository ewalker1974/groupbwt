<?php

namespace App\Service\Batch\Component\Rule;

use App\Service\CardCountry;
use App\Service\CurrencyRateCalculator;
use App\ValueObject\Transaction;

abstract class CustomCommissionRule extends BaseRule
{
    private const string BASE_CURRENCY = 'EUR';

    public function __construct(protected readonly CardCountry $cardCountry, private readonly CurrencyRateCalculator $rate)
    {
    }

    #[\Override]
    protected function calcCommission(Transaction $transaction): float
    {
        return $this->rate->convert($transaction->getCurrency(), self::BASE_CURRENCY, $transaction->getAmount()) * $this->getCommissionRate();
    }

    abstract protected function getCommissionRate(): float;
}
