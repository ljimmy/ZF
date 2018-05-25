<?php

namespace SF\Exceptions\Protocol\Rpc;

use SF\Exceptions\UserException;

class RpcException extends UserException
{
    public function toString() {
        return $this->getMessage();
    }
}