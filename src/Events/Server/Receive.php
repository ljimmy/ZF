<?php

namespace SF\Events\Server;


use SF\IoC\Container;
use SF\Protocol\ProtocolServiceProvider;
use Swoole\Server;

class Receive extends AbstractServerEvent
{
    /**
     * @var ProtocolServiceProvider
     */
    public $protocolServiceProvider;

    public function __construct(Container $container)
    {
        $this->protocolServiceProvider = $container->get(ProtocolServiceProvider::class)->getProtocol();
    }

    /**
     * @param Server $server
     * @param int $fd
     * @param int $reactor_id
     * @param string $data
     */
    public function callback($server = null, int $fd = 0, int $reactor_id = 0, string $data = '')
    {


        $message = $this->protocolServiceProvider->getMiddleware()->process(
            $this->protocolServiceProvider->getProtocol()->receive($data),
            null
        );

        $server->send($fd, $this->protocolServiceProvider->getProtocol()->reply($message));
    }

    public function on($server)
    {
        $server->on('Receive', [$this, 'callback']);
    }

}
