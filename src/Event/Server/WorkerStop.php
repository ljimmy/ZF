<?php

namespace SF\Event\Server;;

use Swoole\Server;
use SF\Context\ApplicationContext;

class WorkerStop extends AbstractServerEvent
{
    public function getName(): string
    {
        return 'WorkerStop';
    }

    public function getCallback(): \Closure
    {
        return function (Server $server, int $workerId) {
            ApplicationContext::getContext()->exitContext();
        };
    }

}
