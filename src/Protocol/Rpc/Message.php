<?php

namespace SF\Protocol\Rpc;

use SF\Protocol\VerifierInterface;

class Message extends \SF\Protocol\Message
{
    public $header;

    public $body;

    /**
     * @var int 消息识别号
     */
    public $xid;


    public function fill(string $str, $length)
    {
        return str_pad($str, $length, 0, STR_PAD_LEFT);
    }

    public function getHeader()
    {
        return $this->header;
    }

    public function getBody()
    {
        return $this->body;
    }


}