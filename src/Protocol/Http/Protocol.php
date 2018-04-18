<?php

namespace SF\Protocol\Http;

use SF\Contracts\IoC\Object;
use SF\Contracts\Protocol\Client;
use SF\Contracts\Protocol\Protocol as ProtocolInterface;
use SF\Contracts\Protocol\Server;
use SF\IoC\Container;

class Protocol implements ProtocolInterface, Object
{
    const NAME = 'HTTP';

    /**
     * @var Server
     */
    public $server = \SF\Protocol\Http\Server::class;

    /**
     * @var Client
     */
    public $client = \SF\Protocol\Http\Client::class;

    /**
     * @var Container
     */
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function init()
    {
        $this->server = $this->container->make($this->server);
    }


    public function getName()
    {
        return self::NAME;
    }

    public function getServer(): Server
    {
        return $this->server;
    }

    public function getClient(): Client
    {
        return $this->client;
    }


}