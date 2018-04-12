<?php

namespace SF\Protocol\Rpc\Exceptions;


class DeniedException extends RpcException
{
    const RPC_MISMATCH = 0;/* rpc 版本不等于2*/

    const AUTH_ERROR   = 1;/* 鉴定错误*/

}