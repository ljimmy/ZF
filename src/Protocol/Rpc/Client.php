<?php

namespace SF\Protocol\Rpc;

use SF\Contracts\Protocol\Client as ClientInterface;

class Client implements ClientInterface
{
    public $host;

    public $port;

    public function call($method = null)
    {

    }

}