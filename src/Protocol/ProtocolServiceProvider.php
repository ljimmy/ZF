<?php

namespace SF\Protocol;

use SF\Di\Container;
use SF\Exceptions\UserException;
use SF\Protocol\Rpc\Protocol;

class ProtocolServiceProvider
{
    /**
     * @var ProtocolInterface
     */
    public $handle;

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
        if ($this->handle === null) {
            throw new UserException('do not set protocol.');
        }
        $this->handle = $this->container->setDefinition($this->handle, null, true);

        if (!$this->handle instanceof ProtocolInterface) {
            throw new UserException('protocol must implement the interface SF\Protocol\ProtocolInterface');
        }

        $this->middleware = new Middleware($this->middleware);
    }

    public function getProtocol(): ProtocolInterface
    {
        return $this->handle;
    }

    public function getMiddleware(): Middleware
    {
        return $this->middleware;
    }
}