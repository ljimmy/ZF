<?php

namespace SF\Event\Server\Http\WebSocket;

use SF\Event\Server\AbstractServerEvent;
use Swoole\Http\Request;
use Swoole\WebSocket\Server;

class Open extends AbstractServerEvent
{
    public function getName(): string
    {
        return 'Open';
    }

    public function getCallback(): \Closure
    {
        return function (Server $server, Request $request) {

        };
    }


}