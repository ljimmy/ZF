<?php

namespace SF\Event\Client;

use Swoole\Client;

class Receive extends AbstractClientEvent
{
    public function getName(): string
    {
        return 'Receive';
    }

    public function getCallback(): \Closure
    {
        return function (Client $client, $data) {

        };
    }

}
