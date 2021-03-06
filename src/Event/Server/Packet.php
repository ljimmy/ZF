<?php

namespace SF\Event\Server;

use Swoole\Server;

class Packet extends AbstractServerEvent
{

    public function getName(): string
    {
        return 'Packet';
    }

    public function getCallback(): \Closure
    {
        return function (Server $server, string $data, array $client_info) {

        };
    }

}
