<?php

namespace SF\Events\Server;

class Shutdown extends AbstractServerEvent
{

    public function callback($server = null)
    {
        echo "Server has stopped working.\n";

    }

    public function on($server)
    {
        $server->on('Shutdown', [$this, 'callback']);
    }

}
