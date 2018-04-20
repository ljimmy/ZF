<?php

namespace SF\Protocol;

use SF\Contracts\IoC\Object;
use SF\Contracts\Protocol\Protocol as ProtocolInterface;
use SF\Exceptions\UserException;
use SF\IoC\Container;

class ProtocolServiceProvider implements Object
{
    /**
     * @var ProtocolInterface[]
     */
    public $protocols = [];

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
        foreach ((array)$this->protocols as $protocol) {
            $this->register($this->container->make($protocol));
        }
    }


    public function register(ProtocolInterface $protocol)
    {
        $this->protocols[strtolower($protocol->getName())] = $protocol;
    }

    public function hasProtocol(string $name)
    {
        return isset($this->protocols[strtolower($name)]);
    }

    public function getProtocol(string $name): ProtocolInterface
    {
        $name = strtolower($name);

        if (isset($this->protocols[$name])) {
            return $this->protocols[$name];
        }

        throw new UserException($name . ' protocol do not set.');
    }
}