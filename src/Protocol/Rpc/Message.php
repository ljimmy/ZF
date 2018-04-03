<?php

namespace SF\Protocol\Rpc;

use SF\Protocol\MessageInterface;

class Message implements MessageInterface
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

    public function receive(): MessageInterface
    {
        // TODO: Implement receive() method.
    }

    public function reply(): string
    {
        // TODO: Implement reply() method.
    }


}