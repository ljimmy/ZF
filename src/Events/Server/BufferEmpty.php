<?php

namespace SF\Events\Server;

use SF\Events\EventInterface;

class BufferEmpty implements EventInterface
{

    public function callback($server = null, int $fd = 0)
    {

    }

    public function on($server)
    {
        $server->on('BufferEmpty', [$this, 'callback']);
    }

}
