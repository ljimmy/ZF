<?php

namespace SF\Events\Server;

use SF\Events\EventInterface;

class Shutdown implements EventInterface
{

    public function callback($server = null)
    {

    }

    public function on($server)
    {
        $server->on('Shutdown', [$this, 'callback']);
    }

}
