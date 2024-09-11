<?php

namespace App\ValueObject;

use App\ValueObject\Impl\TransactionImpl;

class SampleTransactionBuilder
{
    private string $card;

    private float $amount;

    private string $currency;

    public function getCard(): string
    {
        return $this->card;
    }

    public function setCard(string $card): self
    {
        $this->card = $card;

        return $this;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function build(): Transaction
    {
        return new TransactionImpl($this->card, $this->amount, $this->currency);
    }
}
