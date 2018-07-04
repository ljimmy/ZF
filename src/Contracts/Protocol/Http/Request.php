<?php

namespace SF\Contracts\Protocol\Http;

use Psr\Http\Message\RequestInterface;
use SF\Contracts\Protocol\Message;

interface Request extends RequestInterface, Message
{

}