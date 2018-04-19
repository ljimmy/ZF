<?php

namespace SF\Protocol\Rpc;


use SF\Contracts\Protocol\Receiver;
use SF\Contracts\Protocol\Replier;
use SF\Protocol\AbstractServer;

class Server extends AbstractServer
{
    public function handle(Receiver $receiver, Replier $replier): string
    {

    }


}