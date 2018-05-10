<?php

namespace SF\Protocol\Rpc\Exceptions;


class DeniedException extends RpcException
{
    public function toString()
    {
        return 'Denied: Invalid message';
    }
}