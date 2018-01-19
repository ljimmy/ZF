<?php

namespace SF\Databases;

use SF\Exceptions\UserException;
use Throwable;

class SqlException extends UserException
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}