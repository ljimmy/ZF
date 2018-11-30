<?php

namespace SF\Protocol;

use SF\Contracts\IoC\Instance;
use SF\Contracts\Protocol\Client;
use SF\Contracts\Protocol\Protocol as ProtocolInterface;
use SF\Contracts\Protocol\Server;
use SF\IoC\Container;

abstract class AbstractProtocol implements ProtocolInterface, Instance
{

    const NAME = 'HTTP';

    /**
     * @var Server
     */
    public $server;

    /**
     * @var Client
     */
    public $client;

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
        if ($this->server) {
            $this->server = $this->container->make($this->server);
        }

        if ($this->client) {
            $this->client = $this->container->make($this->client);
        }
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