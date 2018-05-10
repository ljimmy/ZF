<?php

namespace SF\Protocol\Rpc\Exceptions;

use SF\Exceptions\UserException;

class RpcException extends UserException
{
    public function toString() {
        return $this->getMessage();
    }
}