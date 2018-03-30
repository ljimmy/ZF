<?php

namespace SF\Protocol\Rpc;


class Message
{
    const CALL = 0;

    const REPLY = 1;

    /**
     * @var int
     */
    public $xid;

    public $mtype;

    public $body;

}