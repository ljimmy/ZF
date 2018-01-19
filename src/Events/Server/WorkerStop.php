<?php

namespace SF\Events\Server;

use SF\Events\EventInterface;

class WorkerStop implements EventInterface
{

    const EVENT_NAME = 'WorkerStop';

    public function callback($server = null, int $workerId = 0)
    {

    }

    public function on($server)
    {
        $server->on('WorkerStop', [$this, 'callback']);
    }

}
