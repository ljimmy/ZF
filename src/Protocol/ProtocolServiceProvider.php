<?php

namespace SF\Protocol;

use SF\Di\Container;
use SF\Exceptions\UserException;

class ProtocolServiceProvider
{
    /**
     * @var ProtocolInterface
     */
    public $protocol;

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
            throw new UserException('do not set protocol.');
        }

        $protocol = $this->container->get($this->protocol);

        if ($protocol instanceof ProtocolInterface) {
            $this->protocol = $protocol;
        } else {
            throw new UserException('protocol must implement the interface SF\Protocol\ProtocolInterface');
        }

    }

    public function getProtocol(): ProtocolInterface
    {
        return $this->protocol;
    }
}