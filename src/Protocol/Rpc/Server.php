<?php

namespace SF\Protocol\Rpc;

use SF\Http\Router;
use SF\Contracts\Protocol\Receiver;
use SF\Contracts\Protocol\Replier;
use SF\Protocol\AbstractServer;
use SF\Exceptions\Protocol\Rpc\RpcException;

class Server extends AbstractServer
{

    public $router = Router::class;

    public function handle(Receiver $receiver, Replier $replier): string
    {
        try {
            $result = $this->getDispatcher()->dispatch($receiver->unpack(), $this->getRouter());
            return $replier->pack($result);
        } catch (RpcException $e) {
            return $e->toString();
        }
    }

}
