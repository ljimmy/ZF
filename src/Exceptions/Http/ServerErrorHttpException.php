<?php

namespace SF\Exceptions\Http;

class ServerErrorHttpException extends HttpException
{

    public function __construct(string $message = "", $code = 0, \Exception $previous = null)
    {
        parent::__construct(500, $message, $code, $previous);
    }

}
