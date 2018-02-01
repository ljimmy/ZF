<?php

namespace SF\Http;

use Swoole\Http\Server;
use SF\Server\AbstractServer;

class HttpServer extends AbstractServer
{

    public $host     = '0.0.0.0';
    public $port     = 9000;
    public $ssl      = false;
    public $mode     = SWOOLE_PROCESS;
    public $sockType = SWOOLE_SOCK_TCP;

    public function __construct(array $config = array())
    {
        parent::__construct($config);

        $http = $this->config->getHttp();

        if (isset($http['host'])) {
            $this->host = $http['host'];
        }
        if (isset($http['port'])) {
            $this->port = $http['port'];
        }
        if (isset($http['ssl'])) {
            $this->ssl = $http['ssl'];
        }
        if (isset($http['mode'])) {
            $this->mode = $http['mode'];
        }
        if (isset($http['sockType'])) {
            $this->sockType = $http['sockType'];
        }
    }

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

    public function start()
    {
        $server = new Server($this->host, $this->port, $this->mode, $this->ssl ? $this->sockType | SWOOLE_SSL : $this->sockType);
        $server->set($this->config->getServer());
        $this->bootstrap($server);
        $server->start();
    }

    public function stop()
    {
        
    }

    public function reload()
    {
        ;
    }

}
