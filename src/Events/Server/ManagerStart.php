<?php

namespace SF\Events\Server;

class ManagerStart extends AbstractServerEvent
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
