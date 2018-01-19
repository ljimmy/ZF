<?php

namespace SF\Events\Server;

use SF\Events\EventInterface;

class Finish implements EventInterface
{

    public function callback($server = null, int $task_id = 0, string $data = '')
    {

    }

    public function on($server)
    {
        $server->on('Finish', [$this, 'callback']);
    }

}
