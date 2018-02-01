<?php

namespace SF\Events\Server;

class BufferFull extends AbstractServerEvent
{

    public function callback($server = null, int $fd = 0)
    {

    }

    public function on($server)
    {
        $server->on('BufferFull', [$this, 'callback']);
    }

}
