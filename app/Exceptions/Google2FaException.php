<?php

namespace App\Exceptions;

use Exception;
use Throwable;

/**
 * Exception for catching errors of unconfirmed Google 2FA codes
 */
class Google2FaException extends Exception
{
    public function __construct($message = "Authorization code not verified.", $code = 403, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
