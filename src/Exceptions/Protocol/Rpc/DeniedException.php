<?php

namespace SF\Exceptions\Protocol\Rpc;


class DeniedException extends RpcException
{
    public function toString()
    {
        return 'Denied: Invalid message';
    }
}