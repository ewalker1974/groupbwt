<?php

namespace App\Tests\Unit;

use App\Type\CountryType;
use App\Util\CountryUtil;
use PHPUnit\Framework\TestCase;

class CountryUtilTest extends TestCase
{
    /**
     * @dataProvider countries
     */
    public function testGetCountryTypeByName(string $countryCode, CountryType $expectedType): void
    {
        $this->assertEquals($expectedType, CountryUtil::getCountryTypeByName($countryCode));
    }

    private function countries(): array
    {
        return [
            'EU country' => ['DK', CountryType::EU],
            'Non EU country' => ['US', CountryType::NON_EU],
        ];
    }
}
