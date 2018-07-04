<?php

namespace SF\Exceptions\Http;

class MethodNotAllowedHttpException extends HttpException
{

    public function __construct(string $message = "", $code = 0, \Exception $previous = null)
    {
        parent::__construct(405, $message, $code, $previous);
    }

}
