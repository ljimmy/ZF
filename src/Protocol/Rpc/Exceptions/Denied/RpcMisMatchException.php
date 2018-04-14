<?php

namespace SF\Protocol\Rpc\Exceptions\Denied;


use SF\Protocol\Rpc\Exceptions\DeniedException;
use Throwable;

class RpcMisMatchException extends DeniedException
{
    public $low;

    public $high;

    public function __construct(int $low = null, int $high = null, string $message = "", int $code = 0, Throwable $previous = null)
    {

        $this->low  = $low;
        $this->high = $high;
        parent::__construct($message, $code, $previous);
    }
}