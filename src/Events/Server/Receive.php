<?php

namespace SF\Events\Server;

class Receive extends AbstractServerEvent
{

    public function callback($server = null, int $fd = 0, int $reactor_id = 0, string $data = '')
    {

    }

    public function on($server)
    {
        $server->on('Receive', [$this, 'callback']);
    }

}
