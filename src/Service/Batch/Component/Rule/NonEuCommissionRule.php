<?php

namespace App\Service\Batch\Component\Rule;

use App\Type\CountryType;
use App\ValueObject\Transaction;

class NonEuCommissionRule extends CustomCommissionRule
{
    protected const float COMMISSION_RATE = 0.02;

    #[\Override]
    public function isApplicable(Transaction $transaction): bool
    {
        return CountryType::NON_EU === $this->cardCountry->getCardCountryType($transaction->getCard());
    }

    #[\Override]
    protected function getCommissionRate(): float
    {
        return self::COMMISSION_RATE;
    }
}
