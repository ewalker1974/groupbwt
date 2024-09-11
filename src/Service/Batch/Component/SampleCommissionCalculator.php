<?php

namespace App\Service\Batch\Component;

use App\Service\Batch\Processor;
use App\Util\OperationValueUtil;
use App\ValueObject\CommissionFee;
use App\ValueObject\SampleCommissionBuilder;
use App\ValueObject\Transaction;

readonly class SampleCommissionCalculator implements Processor
{
    public function __construct(
        /** @var array<int, Rule> */
        private array $rules = [],
    ) {
    }

    #[\Override]
    public function getCommission(Transaction $transaction): CommissionFee
    {
        $currentFee = 0;
        foreach ($this->rules as $rule) {
            if ($rule->isApplicable($transaction)) {
                $currentFee = $rule->getCommission($transaction);
            }
        }

        return (new SampleCommissionBuilder())->setValue($this->normalizeFee($currentFee))->build();
    }

    private function normalizeFee(float $currentFee): float
    {
        return OperationValueUtil::roundToCents($currentFee, 2);
    }
}
