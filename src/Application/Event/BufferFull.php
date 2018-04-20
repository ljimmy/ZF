<?php

namespace SF\Application\Event;

use Swoole\Server;

class BufferFull extends AbstractServerEvent
{
    public function getName(): string
    {
        return 'BufferFull';
    }

    public function getCallback(): \Closure
    {
        return function(Server $server, $fd){

        };
    }

}
