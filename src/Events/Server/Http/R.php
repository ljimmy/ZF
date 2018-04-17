<?php

namespace SF\Events\Server\Http;


use SF\Di\Container;
use SF\Http\Receiver;
use SF\Http\Replier;
use SF\Protocol\ProtocolServiceProvider;

class R
{
    /**
     * @var ProtocolServiceProvider
     */
    private $provider;

    public function __construct(Container $container)
    {
        $this->provider = $container->get(ProtocolServiceProvider::class);
    }


    public function on($server)
    {
        $server->on('Request', [$this, 'callback']);
    }

    /**
     * @param \Swoole\Http\Request $request
     * @param \Swoole\Http\Response $response
     */
    public function callback($request = null, $response = null)
    {
        $this->provider->getProtocol()->handle(new Receiver($request), new Replier($response));
    }

}