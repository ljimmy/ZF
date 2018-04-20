<?php

namespace SF\Application\Event;

use Swoole\Server;

class ManagerStart extends AbstractServerEvent
{
    public function getName(): string
    {
        return 'ManagerStart';
    }

    public function getCallback(): \Closure
    {
        return function (Server $server) {
            setProcessTitle('SF Manager Process');

        };
    }

}
