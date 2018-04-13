<?php

namespace SF\Protocol\Rpc\Exceptions;


class DeniedException extends RpcException
{
    const RPC_MISMATCH = 0;/* rpc 版本错误*/

    const AUTH_ERROR   = 1;/* 鉴定错误*/

}