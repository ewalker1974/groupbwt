<?php

namespace App\Exception;

class BadParamException extends \Exception
{
    public const int PARAM_NOT_FOUND = 1;

    public const int PARAM_VALUE_INVALID = 2;

    private const array ERROR_MESSAGES = [
        1 => 'The following param %s not found',
        2 => 'Invalid param value %s',
    ];

    public function __construct(int $code, ?string $messageParam = null, ?\Throwable $previous = null)
    {
        parent::__construct($this->getErrorMessage($code, $messageParam), $code, $previous);
    }

    private function getErrorMessage(int $code, ?string $messageParam): string
    {
        if (isset(self::ERROR_MESSAGES[$code])) {
            if (null !== $messageParam) {
                return sprintf(self::ERROR_MESSAGES[$code], $messageParam);
            }

            return self::ERROR_MESSAGES[$code];
        }

        return 'Unknown parsing client error';
    }
}
