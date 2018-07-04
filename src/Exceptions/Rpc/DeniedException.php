<?php

namespace SF\Exceptions\Rpc;

class DeniedException extends RpcException
{

    public function toString()
    {
        return 'Denied: Invalid message';
    }
}