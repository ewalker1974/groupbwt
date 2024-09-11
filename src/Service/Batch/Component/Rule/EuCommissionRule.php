<?php

namespace App\Service\Batch\Component\Rule;

use App\Type\CountryType;
use App\ValueObject\Transaction;

class EuCommissionRule extends CustomCommissionRule
{
    private const float COMMISSION_RATE = 0.01;

    #[\Override]
    public function isApplicable(Transaction $transaction): bool
    {
        return CountryType::EU === $this->cardCountry->getCardCountryType($transaction->getCard());
    }

    #[\Override]
    protected function getCommissionRate(): float
    {
        return self::COMMISSION_RATE;
    }
}
