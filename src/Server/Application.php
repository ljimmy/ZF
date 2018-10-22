<?php

namespace SF\Server;

use SF\Contracts\Event\Server as ServerEventInterface;
use SF\Event\EventManager;
use SF\Event\EventTypes;
use SF\IoC\Container;
use Swoole\Server;

class Application
{

    protected $host;

    protected $port;

    protected $type;

    protected $events    = [];

    protected $setting   = [];

    protected $multiport = [];

    protected $container;

    protected $components;

    /**
     * @var Server
     */
    protected $server;

    /**
     *
     * @var self
     */
    protected static $app;

    public function __construct(array $config = [])
    {
        self::$app = $this;


        $this->host      = $config['host'] ?? '127.0.0.1';
        $this->port      = $config['port'] ?? 0;
        $this->type      = $config['type'] ?? SWOOLE_SOCK_TCP;
        $this->events    = $config['events'] ?? [];
        $this->setting   = $config['setting'] ?? [];
        $this->multiport = $config['multiport'] ?? [];
        $this->container = new Container();
        $this->joinContainer();
    }

    public function setComponentsConfig(string $file = '')
    {
        $this->components = $file ? realpath($file) : '';
    }

    /**
     *
     * @return self
     */
    public static function getApp()
    {
        return self::$app;
    }

    public function registerComponents()
    {
        if ($this->components) {
            $components = include($this->components);
            $this->container->setDefinitions($components);
        }
    }

    public function getServer()
    {
        return $this->server;
    }

    /**
     *
     * @return Container
     */
    public function getContainer(): Container
    {
        return $this->container;
    }

    public function start()
    {
        $this->server = $this->createServer();
        $this->registerComponents();

        $this->server->set($this->setting);
        array_map(function ($event) {
            $this->bindEvent($this->container->make($event), $this->server);
        }, $this->events);

        $this->bindMultiport();

        $this->container->get(EventManager::class)->trigger(EventTypes::SERVER_INIT);
        $this->server->start();
    }

    protected function createServer()
    {
        return new Server($this->host, $this->port, SWOOLE_PROCESS, $this->type);
    }

    protected function bindEvent(ServerEventInterface $event, $target)
    {
        $target->on($event->getName(), $event->getCallback());
    }

    protected function bindMultiport()
    {
        foreach ($this->multiport as $value) {
            $port = $this->server->addListener(
                    $value['host'] ?? $this->host, $value['port'] ?? $this->port, $value['type'] ?? $this->type
            );
            if ($port === false) {
                throw new \Exception($this->server->getLastError());
            }

            $port->set($value['setting'] ?? []);
            array_map(function ($event) use ($port) {
                $this->bindEvent($this->container->make($event), $port);
            }, $value['events'] ?? []);
        }
    }

    public function reload()
    {
        $this->server->reload();
    }

    public function reloadProcess()
    {
        $this->container->clear();
        $this->joinContainer();


        $this->registerComponents();
    }

    protected function joinContainer()
    {
        $this->container->set(self::class, $this);
    }

}
