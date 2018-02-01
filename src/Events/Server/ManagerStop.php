<?php

namespace SF\Events\Server;

class ManagerStop extends AbstractServerEvent
{

    public function callback($server = null)
    {

    }

    public function on($server)
    {
        $server->on('ManagerStop', [$this, 'callback']);
    }

}
