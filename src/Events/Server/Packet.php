<?php

namespace SF\Events\Server;

class Packet extends AbstractServerEvent
{

    public function callback($server = null, string $data = '', array $client_info = [])
    {

    }

    public function on($server)
    {
        $server->on('Packet', [$this, 'callback']);
    }

}
