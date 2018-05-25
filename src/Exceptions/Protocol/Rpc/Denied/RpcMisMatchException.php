<?php

namespace SF\Exceptions\Protocol\Rpc\Denied;

use SF\Exceptions\Protocol\Rpc\DeniedException;
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

    public function toString()
    {
        return 'Denied: Version must in [' . $this->low . '-' . $this->high . ']';
    }

}
