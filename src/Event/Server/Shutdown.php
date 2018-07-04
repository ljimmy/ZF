<?php

namespace SF\Event\Server;

use Swoole\Server;

class Shutdown extends AbstractServerEvent
{

    public function getName(): string
    {
        return 'Shutdown';
    }

    public function getCallback(): \Closure
    {
        return function (Server $server) {

        };
    }
}
