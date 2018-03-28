<?php

namespace SF\Http;

use Swoole\Http\Server;
use SF\Server\AbstractServer;

class HttpServer extends AbstractServer
{
    /**
     *
     * @return Dispatcher
     */
    public function getDispatcher()
    {
        return $this->getContainer()->get(Dispatcher::class);
    }

    /**
     *
     * @return RouteInterface
     */
    public function getRoute()
    {
        return $this->getContainer()->get('router');
    }

    /**
     *
     * @return Middleware
     */
    public function getMiddleware()
    {
        return $this->getContainer()->get(Middleware::class);
    }

    protected function createServer()
    {
        return new Server($this->host, $this->port, $this->mode, $this->ssl ? $this->sockType | SWOOLE_SSL : $this->sockType);
    }

    public function stop()
    {
        
    }

    public function reload()
    {
        $this->init();
        $this->server->reload();
    }

}
