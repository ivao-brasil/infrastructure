<?php

namespace IvaoBrasil\Infrastructure\Exceptions;

use InvalidArgumentException;
use Throwable;

class InvalidUserDataException extends InvalidArgumentException
{
    public function __construct(?int $code = 0, Throwable $previous = null)
    {
        parent::__construct('The user data from remote is missing or invalid', $code, $previous);
    }
}
