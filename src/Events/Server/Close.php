<?php

namespace SF\Events\Server;

class Close extends AbstractServerEvent
{

    public function callback($server = null, int $fd = 0, int $reactorId = 0)
    {

    }

    public function on($server)
    {
        $server->on('Close', [$this, 'callback']);
    }

}
