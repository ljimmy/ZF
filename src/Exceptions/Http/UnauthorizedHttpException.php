<?php

namespace SF\Exceptions\Http;

class UnauthorizedHttpException extends HttpException
{

    public function __construct(string $message = "", $code = 0, \Exception $previous = null)
    {
        parent::__construct(401, $message, $code, $previous);
    }

}
