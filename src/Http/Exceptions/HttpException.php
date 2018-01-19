<?php
namespace SF\Http\Exceptions;

use SF\Exceptions\UserException;

class HttpException extends UserException
{
    public $statusCode;


    public function __construct(int $status, string $message = "", int $code = 0, \Throwable $previous = null)
    {
        $this->statusCode = $status;

        parent::__construct($message, $code, $previous);
    }

    public function getError()
    {
        return $this->getMessage() ?: $this->getName();
    }
}
