<?php

namespace SF\Application\Event;


use SF\IoC\Container;
use SF\Protocol\ProtocolServiceProvider;
use SF\Protocol\Rpc\Protocol;
use Swoole\Server;

class Receive extends AbstractServerEvent
{
    /**
     * @var ProtocolServiceProvider
     */
    public $protocolServiceProvider;

    public function __construct(Container $container)
    {
        $this->protocolServiceProvider = $container->get(ProtocolServiceProvider::class);
    }

    public function getName(): string
    {
        return 'Receive';
    }

    public function getCallback(): \Closure
    {
        return function (Server $server, $fd, $reactor_id, $data) {
            echo $fd;
            $server->send($fd, '123');
            $server->close($fd);
        };
    }

    /**
     * @param Server $server
     * @param int $fd
     * @param int $reactor_id
     * @param string $data
     */
    public function callback($server = null, int $fd = 0, int $reactor_id = 0, string $data = '')
    {
        var_dump(1);

        return 1;

        if (!$this->protocolServiceProvider->hasProtocol(Protocol::NAME)) {
            return null;
        }


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
