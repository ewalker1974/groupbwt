<?php

namespace App\Util;

use App\Type\CountryType;

final class CountryUtil extends BaseUtil
{
    private const array COUNTRIES = [
        'AT',
        'BE',
        'BG',
        'CY',
        'CZ',
        'DE',
        'DK',
        'EE',
        'ES',
        'FI',
        'FR',
        'GR',
        'HR',
        'HU',
        'IE',
        'IT',
        'LT',
        'LU',
        'LV',
        'MT',
        'NL',
        'PO',
        'PT',
        'RO',
        'SE',
        'SI',
        'SK',
    ];

    public static function getCountryTypeByName(string $country): CountryType
    {
        return in_array(strtoupper($country), self::COUNTRIES) ? CountryType::EU : CountryType::NON_EU;
    }
}
