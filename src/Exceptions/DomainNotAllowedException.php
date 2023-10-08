<?php

namespace IvaoBrasil\Infrastructure\Exceptions;

use InvalidArgumentException;
use Throwable;

class DomainNotAllowedException extends InvalidArgumentException
{
    public function __construct(string $domain, ?int $code = 0, Throwable $previous = null)
    {
        parent::__construct($this->getFormattedMessage($domain), $code, $previous);
    }

    private function getFormattedMessage(string $domain): string
    {
        return "The domain $domain is not allowed to use the Login API! Contact the System Administrator";
    }
}
