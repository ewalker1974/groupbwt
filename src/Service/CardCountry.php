<?php

namespace App\Service;

use App\Type\CountryType;
use App\Util\CountryUtil;

readonly class CardCountry
{
    public function __construct(private CardService $cardService)
    {
    }

    public function getCardCountryType(string $bin): CountryType
    {
        return CountryUtil::getCountryTypeByName($this->cardService->getCardCountry($bin));
    }
}
