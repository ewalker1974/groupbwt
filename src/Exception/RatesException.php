<?php

namespace App\Exception;

class RatesException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Currency rates get error');
    }
}
