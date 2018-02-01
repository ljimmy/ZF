<?php

namespace SF\Events\Server;

class BufferEmpty extends AbstractServerEvent
{

    public function callback($server = null, int $fd = 0)
    {

    }

    public function on($server)
    {
        $server->on('BufferEmpty', [$this, 'callback']);
    }

}
