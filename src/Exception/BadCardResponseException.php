<?php

namespace App\Exception;

class BadCardResponseException extends \Exception
{
    public function __construct(?\Throwable $previous = null)
    {
        parent::__construct('Bad Card Response', 0, $previous);
    }
}
