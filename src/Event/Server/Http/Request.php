<?php

namespace SF\Event\Server\Http;

use SF\Event\Server\AbstractServerEvent;
use SF\Http\Receiver;
use SF\Http\Replier;
use SF\IoC\Container;
use SF\Protocol\Http\Protocol;
use SF\Protocol\ProtocolServiceProvider;

class Request extends AbstractServerEvent
{

    public $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function getName(): string
    {
        return 'Request';
    }

    public function getCallback(): \Closure
    {
        return
            /**
             * @param \Swoole\Http\Request $request
             * @param \Swoole\Http\Response $response
             */
            function (\Swoole\Http\Request $request, \Swoole\Http\Response $response) {
                $this->container->get(ProtocolServiceProvider::class)
                    ->getProtocol(Protocol::NAME)
                    ->getServer()
                    ->handle(
                        new Receiver($request),
                        new Replier($response)
                );
            };
    }
}