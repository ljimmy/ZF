<?php

namespace SF\Protocol\Rpc;

class Message extends \SF\Protocol\Message
{
    const CALL = 0;

    const REPLY = 1;

    /**
     * @var int
     */
    public $xid;

    /**
     *
     * @var int CALL|REPLY
     */
    public $type;


    public function fill(string $str, $length)
    {
        return str_pad($str, $length, 0, STR_PAD_LEFT);
    }

    public function getHeader()
    {

    }

    public function getBody()
    {

    }


}