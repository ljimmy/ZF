<?php

namespace SF\Event\Client;

use Swoole\Client;

class BufferEmpty extends AbstractClientEvent
{
    public function getName(): string
    {
        return 'BufferEmpty';
    }

    public function getCallback(): \Closure
    {
        return function (Client $client) {

        };
    }

}
