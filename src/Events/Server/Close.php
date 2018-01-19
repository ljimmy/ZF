<?php

namespace SF\Events\Server;

use SF\Events\EventInterface;

class Close implements EventInterface
{

    public function callback($server = null, int $fd = 0, int $reactorId = 0)
    {

    }

    public function on($server)
    {
        $server->on('Close', [$this, 'callback']);
    }

}
