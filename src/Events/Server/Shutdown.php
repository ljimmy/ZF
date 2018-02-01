<?php

namespace SF\Events\Server;

class Shutdown extends AbstractServerEvent
{

    public function callback($server = null)
    {

    }

    public function on($server)
    {
        $server->on('Shutdown', [$this, 'callback']);
    }

}
