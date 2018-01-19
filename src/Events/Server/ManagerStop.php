<?php

namespace SF\Events\Server;

use SF\Events\EventInterface;

class ManagerStop implements EventInterface
{

    public function callback($server = null)
    {

    }

    public function on($server)
    {
        $server->on('ManagerStop', [$this, 'callback']);
    }

}
