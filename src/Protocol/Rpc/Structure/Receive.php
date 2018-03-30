<?php

namespace SF\Protocol\Rpc\Structure;


class Receive
{
    public $rpcvers = 2;

    public $prog;

    public $vers;

    public $proc;

    public $cred;
}