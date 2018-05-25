<?php

namespace SF\Event\Client;

use Swoole\Client;

class Close extends AbstractClientEvent
{
    public function getName(): string
    {
        return 'Close';
    }

    public function getCallback(): \Closure
    {
        return function (Client $client) {

        };
    }

}
