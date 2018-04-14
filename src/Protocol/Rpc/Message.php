<?php

namespace SF\Protocol\Rpc;

use SF\Protocol\ProtocolServiceProvider;

class Message extends \SF\Protocol\Message
{
    /**
     * @var \SF\Contracts\Protocol\Protocol
     */
    public $protocol;

    public function __construct(ProtocolServiceProvider $provider)
    {
        $this->protocol = $provider->getProtocol();
    }


}