<?php

namespace SF\Events\Server;

class WorkerStop extends AbstractServerEvent
{

    public function callback($server = null, int $workerId = 0)
    {

    }

    public function on($server)
    {
        $server->on('WorkerStop', [$this, 'callback']);
    }

}
