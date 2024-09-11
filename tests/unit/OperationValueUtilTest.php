<?php

namespace App\Tests\Unit;

use App\Util\OperationValueUtil;
use PHPUnit\Framework\TestCase;

class OperationValueUtilTest extends TestCase
{
    /**
     * @dataProvider values
     */
    public function testRoundToCents(float $value, int $radix, float $expected): void
    {
        $this->assertEquals(OperationValueUtil::roundToCents($value, $radix), $expected);
    }

    private function values(): array
    {
        return [
            'cents radix1 ' => [10.250001, 2, 10.26],
            'cents radix2 ' => [10.258, 2, 10.26],
            'cents radix3 ' => [10.2500, 2, 10.25],
            'currency radix' => [10.25, 0, 11],
        ];
    }
}
