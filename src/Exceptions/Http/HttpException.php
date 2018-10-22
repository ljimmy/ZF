<?php
namespace SF\Exceptions\Http;

use SF\Exceptions\UserException;
use SF\Protocol\Http\Response;

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

    public function getName()
    {
        return '';
    }
}
