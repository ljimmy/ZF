<?php

namespace SF\Protocol\Rpc;

use SF\Protocol\ProtocolServiceProvider;

class Message extends \SF\Protocol\Message
{
    /**
     * @var \SF\Contracts\Protocol\Protocol
     */
    public $protocol;

    /**
     * @var \SF\Contracts\Protocol\Authenticator
     */
    public $authenticator;

    /**
     * @var string
     */
    public $body;

    public function __construct(ProtocolServiceProvider $provider)
    {
        $this->protocol      = $provider->getProtocol();
        $this->authenticator = $this->protocol->getAuthenticator();
    }


}