<?php

namespace App\Service;

interface CardService
{
    public function getCardCountry(string $bin): string;
}
