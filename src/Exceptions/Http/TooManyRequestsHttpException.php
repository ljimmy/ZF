<?php

namespace SF\Exceptions\Http;

class TooManyRequestsHttpException extends HttpException
{

    public function __construct(string $message = "", $code = 0, \Exception $previous = null)
    {
        parent::__construct(429, $message, $code, $previous);
    }

}
