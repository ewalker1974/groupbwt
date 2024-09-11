<?php

namespace App\ValueObject\Impl;

use App\ValueObject\Transaction;

readonly class TransactionImpl implements Transaction
{
    public function __construct(
        private string $card,
        private float $amount,
        private string $currency,
    ) {
    }

    #[\Override]
    public function getCard(): string
    {
        return $this->card;
    }

    #[\Override]
    public function getAmount(): float
    {
        return $this->amount;
    }

    #[\Override]
    public function getCurrency(): string
    {
        return $this->currency;
    }
}
