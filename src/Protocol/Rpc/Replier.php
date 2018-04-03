<?php

namespace SF\Protocol\Rpc;


use SF\Protocol\ReplierInterface;
use SF\Protocol\Rpc\Message;

abstract class Replier extends Message implements ReplierInterface
{
    const ACCEPTED = 0;

    const DENIED = 1;

    /**
     * @var int
     */
    public $type = self::REPLY;

    /**
     * @var int
     */
    public $status;


}