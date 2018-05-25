<?php

namespace SF\Event\Client;

use Swoole\Client;

class Error extends AbstractClientEvent
{
    public function getName(): string
    {
        return 'error';
    }

    public function getCallback(): \Closure
    {
        return function (Client $client) {

        };
    }


}