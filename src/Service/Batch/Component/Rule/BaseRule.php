<?php

namespace App\Service\Batch\Component\Rule;

use App\Service\Batch\Component\Rule;
use App\ValueObject\Transaction;

abstract class BaseRule implements Rule
{
    #[\Override]
    abstract public function isApplicable(Transaction $transaction): bool;

    #[\Override]
    public function getCommission(Transaction $transaction): float
    {
        if (!$this->isApplicable($transaction)) {
            throw new \LogicException('Cannot apply rule '.self::class.'to transaction '.implode(',', [$transaction->getCard(), $transaction->getCurrency(), $transaction->getAmount()]));
        }

        return $this->calcCommission($transaction);
    }

    abstract protected function calcCommission(Transaction $transaction): float;
}
