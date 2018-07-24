<?php

namespace SF\Protocol\Http;

use SF\Contracts\Protocol\Client as ClientInterface;
use SF\Contracts\Protocol\Message as MessageInterface;

class Client implements ClientInterface
{
    public function call(string $destination, MessageInterface $message = null)
    {

    }


}