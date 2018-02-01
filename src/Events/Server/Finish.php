<?php

namespace SF\Events\Server;

class Finish extends AbstractServerEvent
{

    public function callback($server = null, int $task_id = 0, string $data = '')
    {

    }

    public function on($server)
    {
        $server->on('Finish', [$this, 'callback']);
    }

}
