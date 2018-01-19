<?php

namespace SF\Events\Server;

use SF\Events\EventInterface;

class WorkerError implements EventInterface
{

    public function callback($server = null, int $worker_id = 0, int $worker_pid = 0, int $exit_code = 0, int $signal = 0)
    {

    }

    public function on($server)
    {
        $server->on('WorkerError', [$this, 'callback']);
    }

}
