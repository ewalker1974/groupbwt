<?php

namespace App\Service\Batch\Component;

use App\ValueObject\Transaction;

interface Rule
{
    public function isApplicable(Transaction $transaction): bool;

    public function getCommission(Transaction $transaction): float;
}
