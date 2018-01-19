<?php

namespace SF\Events\Server;

use SF\Events\EventInterface;

class Packet implements EventInterface
{

    public function callback($server = null, string $data = '', array $client_info = [])
    {

    }

    public function on($server)
    {
        $server->on('Packet', [$this, 'callback']);
    }

}
