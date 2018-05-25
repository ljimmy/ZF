<?php

namespace SF\Event\Client;

use Swoole\Client;

class BufferFull extends AbstractClientEvent
{
    public function getName(): string
    {
        return 'BufferFull';
    }

    public function getCallback(): \Closure
    {
        return function (Client $client) {

        };
    }

}
