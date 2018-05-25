<?php

namespace SF\Event\Client;

use Swoole\Client;

class Connect extends AbstractClientEvent
{
    public function getName(): string
    {
        return 'Connect';
    }

    public function getCallback(): \Closure
    {
        return function (Client $client) {

        };
    }


}
