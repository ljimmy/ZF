<?php

namespace SF\Protocol\Rpc\Exceptions\Denied;

use SF\Protocol\Rpc\Exceptions\DeniedException;
use Throwable;

class MissingParameter extends DeniedException
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
