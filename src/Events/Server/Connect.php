<?php

namespace SF\Events\Server;

use SF\Events\EventInterface;

class Connect implements EventInterface
{

    public function callback($server = null, int $fd = 0, int $reactorId = 0)
    {

    }

    public function on($server)
    {
        $server->on('Connect', [$this, 'callback']);
    }

}
