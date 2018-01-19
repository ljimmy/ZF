<?php

namespace SF\Events\Server;

use SF\Events\EventInterface;

class ManagerStart implements EventInterface
{

    public function callback($server = null)
    {
        setProcessTitle('SF Manager Process');
    }

    public function on($server)
    {
        $server->on('ManagerStart', [$this, 'callback']);
    }

}
