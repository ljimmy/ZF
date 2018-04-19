<?php

namespace SF\Protocol\Http;

use SF\Contracts\Protocol\Client as ClientInterface;
use SF\Contracts\Protocol\Server as ServerInterface;
use SF\Protocol\AbstractProtocol;

class Protocol extends AbstractProtocol
{
    const NAME = 'HTTP';

    /**
     * @var ServerInterface
     */
    public $server = Server::class;

    /**
     * @var ClientInterface
     */
    public $client = Client::class;


    public function getName()
    {
        return self::NAME;
    }


}