<?php

namespace SF\Event\Server\Http\WebSocket;

use SF\Event\Server\AbstractServerEvent;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;

class Message extends AbstractServerEvent
{

    public function getName(): string
    {
        return 'Message';
    }

    public function getCallback(): \Closure
    {
        return function (Server $server, Frame $frame){

        };
    }


}