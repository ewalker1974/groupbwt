<?php

namespace App\Tests\Trait;

use App\ValueObject\Transaction;
use PHPUnit\Framework\MockObject\Stub;

trait TransactionTrait
{
    abstract protected function createStub(string $originalClassName): Stub;

    protected function createTransaction(string $card, string $currency, float $amount): Transaction
    {
        $transaction = $this->createStub(Transaction::class);
        $transaction
            ->method('getCard')
            ->willReturn($card);
        $transaction
            ->method('getAmount')
            ->willReturn($amount);
        $transaction
            ->method('getCurrency')
            ->willReturn($currency);

        return $transaction;
    }
}
