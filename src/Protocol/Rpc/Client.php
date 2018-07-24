<?php

namespace SF\Protocol\Rpc;

use SF\Contracts\Protocol\Client as ClientInterface;
use SF\Contracts\Protocol\Message as MessageInterface;

class Client implements ClientInterface
{
    public $host;

    public $port;

    public function call(string $destination, MessageInterface $message = null)
    {

    }


}