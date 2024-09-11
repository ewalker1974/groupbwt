<?php

namespace App\Service\Batch;

use App\ValueObject\CommissionFee;
use App\ValueObject\Transaction;

interface Processor
{
    public function getCommission(Transaction $transaction): CommissionFee;
}
