<?php

namespace SF\Server;

use SF\Base\Config;
use SF\Di\Container;
use SF\Events\EventManager;
use SF\Events\EventTypes;
use Swoole\Server;

abstract class AbstractServer
{
    /**
     * @var string 监听的ip地址
     */
    public $host     = '0.0.0.0';

    /**
     * @var int 端口
     */
    public $port     = 9000;

    /**
     * @var bool 启用ssl
     */
    public $ssl      = false;

    /**
     * @var int 运行的模式
     */
    public $mode     = SWOOLE_PROCESS;

    /**
     * @var int Socket的类型
     */
    public $sockType = SWOOLE_SOCK_TCP;

    /**
     *
     * @var Container
     */
    protected $container;

    /**
     *
     * @var Config
     */
    protected $config;


    protected $server;

    /**
     *
     * @var \SF\Context\ApplicationContext
     */
    public $context;

    public function __construct(array $config = [])
    {
        $this->config    = new Config($config);

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

        $this->init();
    }

    public function init()
    {
        $this->container = new Container();
        $this->container->set(self::class, $this);

        $this->registerComponents($this->config->getComponents());

    }


    protected function registerComponents(array $components)
    {
        $this->container->setDefinitions($components);
        foreach ($components as $alias => $component) {
            $this->container->get($component['class'] ?? $alias);
        }
    }

    public function triggerEvent()
    {
        $this->container->get(EventManager::class)->trigger(EventTypes::SERVER_INIT, $this->server);
    }

    public function getContainer()
    {
        return $this->container;
    }

    public function getServer()
    {
        return $this->server;
    }

    public function getConfig(): Config
    {
        return $this->config;
    }

    abstract public function start();

    abstract public function stop();

    abstract public function reload();
}
