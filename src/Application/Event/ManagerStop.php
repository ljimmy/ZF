<?php

namespace SF\Application\Event;

use Swoole\Server;

class ManagerStop extends AbstractServerEvent
{
    public function getName(): string
    {
        return 'ManagerStop';
    }

    public function getCallback(): \Closure
    {
        return function (Server $server){

        };
    }

}
