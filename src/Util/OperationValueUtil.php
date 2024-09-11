<?php

namespace App\Util;

final class OperationValueUtil extends BaseUtil
{
    public static function roundToCents(float $value, int $radix): float
    {
        $pow = 10 ** $radix;

        return (ceil($pow * $value) + ceil($pow * $value - ceil($pow * $value))) / $pow;
    }
}
