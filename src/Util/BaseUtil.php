<?php

namespace App\Util;

class BaseUtil
{
    private function __construct()
    {
        throw new \LogicException('This code should not be executed');
    }

    private function __clone()
    {
        throw new \LogicException('This code should not be executed');
    }
}
