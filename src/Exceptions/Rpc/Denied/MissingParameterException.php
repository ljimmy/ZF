<?php

namespace SF\Exceptions\Rpc\Denied;

use SF\Exceptions\Rpc\DeniedException;
use Throwable;

class MissingParameterException extends DeniedException
{

    private $parameter;


    public function __construct($parameter, string $message = "", int $code = 0, Throwable $previous = null)
    {
        $this->parameter = $parameter;
        parent::__construct($message, $code, $previous);
    }

    public function toString()
    {
        return 'Denied: Required Parameter is missing '.$this->parameter;
    }
}
