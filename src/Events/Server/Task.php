<?php

namespace SF\Events\Server;

use SF\Events\EventInterface;

class Task implements EventInterface
{

    public function callback($server = null, int $task_id = 0, int $src_worker_id = 0, $data = null)
    {

    }

    public function on($server)
    {
        $server->on('Task', [$this, 'callback']);
    }

}
