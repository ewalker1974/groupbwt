<?php

namespace App\Service\Batch;

use App\ValueObject\CommissionFee;

interface Writer
{
    public function open(): void;

    public function write(CommissionFee $commissionFee);

    public function close(): void;
}
