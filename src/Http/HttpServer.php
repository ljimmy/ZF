<?php

namespace SF\Http;

use Swoole\Http\Server;
use SF\Server\AbstractServer;
use SF\Events\Server\BufferEmpty;
use SF\Events\Server\BufferFull;
use SF\Events\Server\Close;
use SF\Events\Server\Connect;
use SF\Events\Server\Finish;
use SF\Events\Server\ManagerStart;
use SF\Events\Server\ManagerStop;
use SF\Events\Server\Packet;
use SF\Events\Server\PipeMessage;
use SF\Events\Server\Receive;
use SF\Events\Server\Shutdown;
use SF\Events\Server\Start;
use SF\Events\Server\Task;
use SF\Events\Server\WorkerError;
use SF\Events\Server\WorkerStart;
use SF\Events\Server\WorkerStop;
use SF\Events\Server\Request as RequestEvent;

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

    protected function getComponents()
    {
        $components = parent::getComponents();

        $components['dispatcher'] = [
            'class' => Dispatcher::class
        ];
        $components['router']     = [
            'class' => Routing\Router::class
        ];
        $components['middleware'] = [
            'class'       => Middleware::class,
            'middlewares' => [
            ]
        ];

        return $components;
    }

    /**
     *
     * @return Dispatcher
     */
    public function getDispatcher()
    {
        return $this->getContainer()->get('dispatcher');
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
        return $this->getContainer()->get('middleware');
    }

    public function bootstrap(\Swoole\Server $server)
    {
        parent::bootstrap($server);

        $events = [
            BufferEmpty::class,
            BufferFull::class,
            Close::class,
            Connect::class,
            Finish::class,
            ManagerStart::class,
            ManagerStop::class,
            Packet::class,
            PipeMessage::class,
            Receive::class,
            Shutdown::class,
            Start::class,
            Task::class,
            WorkerError::class,
            WorkerStart::class,
            WorkerStop::class,
            RequestEvent::class,
        ];
        $this->registerEvents($events);
        $server->start();
    }

    public function start()
    {
        $server = new Server($this->host, $this->port, $this->mode, $this->ssl ? $this->sockType | SWOOLE_SSL : $this->sockType);
        $server->set($this->config->getServer());
        $this->bootstrap($server);
    }

    public function stop()
    {
        
    }

    public function reload()
    {
        ;
    }

}
