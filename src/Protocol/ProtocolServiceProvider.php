<?php

namespace SF\Protocol;

use SF\Contracts\IoC\Object;
use SF\IoC\Container;
use SF\Contracts\Protocol\Protocol;
use SF\Exceptions\UserException;

class ProtocolServiceProvider implements Object
{
    /**
     * @var Protocol
     */
    public $protocol;

    public $middleware = [];

    /**
     * @var Container
     */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function init()
    {
        if ($this->protocol === null) {
            throw new UserException('Service do not set protocol.');
        }
        $this->protocol = $this->container->make($this->protocol);

        if (!$this->protocol instanceof Protocol) {
            throw new UserException('protocol must implement the interface SF\Protocol\ProtocolInterface');
        }
    }

    public function getProtocol(): Protocol
    {
        return $this->protocol;
    }
}