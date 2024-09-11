<?php

namespace App\Service\Batch\Component;

use App\Service\Batch\Writer;
use App\ValueObject\CommissionFee;

class ArrayCommissionWriter implements Writer
{
    /** @var CommissionFee[] */
    private array $commissions = [];

    #[\Override]
    public function open(): void
    {
        $this->commissions = [];
    }

    #[\Override]
    public function write(CommissionFee $commissionFee): void
    {
        $this->commissions[] = $commissionFee;
    }

    #[\Override]
    public function close(): void
    {
        // currently nothing to do
    }

    public function getCommissions(): array
    {
        return $this->commissions;
    }
}
