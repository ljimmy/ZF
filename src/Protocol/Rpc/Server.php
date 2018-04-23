<?php

namespace SF\Protocol\Rpc;


use SF\Contracts\Protocol\Receiver;
use SF\Contracts\Protocol\Replier;
use SF\IoC\Container;
use SF\Protocol\AbstractServer;
use SF\Protocol\ProtocolServiceProvider;

class Server extends AbstractServer
{
    public function handle(Receiver $receiver, Replier $replier): string
    {
        $result = $this->getDispatcher()->dispatch($receiver->unpack(), $this->getRouter());

        return $replier->pack($result);
    }


}