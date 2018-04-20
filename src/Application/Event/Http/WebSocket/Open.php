<?php

namespace SF\Application\Event\Http\WebSocket;

use SF\Application\Event\AbstractServerEvent;
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