<?php

namespace SF\Application\Event;

use Swoole\Server;

class WorkerStop extends AbstractServerEvent
{
    public function getName(): string
    {
        return 'WorkerStop';
    }

    public function getCallback(): \Closure
    {
        return function (Server $server, int $workerId) {

        };
    }

}
