<?php

namespace SF\Event\Server\Rpc;

use SF\IoC\Container;
use SF\Server\Connection;
use SF\Coroutine\Coroutine;
use SF\Protocol\Rpc\Replier;
use SF\Protocol\Rpc\Receiver;
use SF\Protocol\Rpc\Protocol;
use SF\Context\ConnectContext;
use SF\Protocol\ProtocolServiceProvider;
use SF\Event\Server\Receive as ReceiveEvent;

class Receive extends ReceiveEvent
{

    /**
     *
     * @var Container
     */
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function getCallback(): \Closure
    {
        $protocol = $this->container->get(ProtocolServiceProvider::class)->getProtocol(Protocol::NAME);
        return function($server, $fd, $reactor_id, $data) use ($protocol) {
            $connectContext = new ConnectContext(new Connection($server, $fd, $reactor_id), /* 开启协程 */ Coroutine::getuid());
            $connectContext->enter();
            
            $receiver = new Receiver($protocol, $data);
            $result = $protocol->getServer()->handle($receiver, new Replier($protocol, $receiver));

            $server->send($fd, $result);
            $connectContext->exitContext();
        };
    }

}
