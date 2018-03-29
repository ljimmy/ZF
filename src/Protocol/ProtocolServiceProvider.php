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

    public function init()
    {
        if ($this->handle === null) {
            throw new UserException('do not set protocol.');
        }

        $this->handle = new $this->handle();

        if (!$this->handle instanceof ProtocolInterface) {
            throw new UserException('protocol must implement the interface SF\Protocol\ProtocolInterface');
        }

    }

    public function getProtocol(): ProtocolInterface
    {
        return $this->handle;
    }
}