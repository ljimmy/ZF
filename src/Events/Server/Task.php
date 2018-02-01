<?php

namespace SF\Events\Server;

class Task extends AbstractServerEvent
{

    public function callback($server = null, int $task_id = 0, int $src_worker_id = 0, $data = null)
    {

    }

    public function on($server)
    {
        $server->on('Task', [$this, 'callback']);
    }

}
