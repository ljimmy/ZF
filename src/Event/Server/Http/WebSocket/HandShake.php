<?php

namespace SF\Event\Server\Http\WebSocket;

use SF\Event\Server\AbstractServerEvent;
use Swoole\Http\Request;
use Swoole\Http\Response;

class HandShake extends AbstractServerEvent
{

    public function getName(): string
    {
        return 'Handshake';
    }

    public function getCallback(): \Closure
    {
        return function (Request $request, Response $response) {
        };
    }

}