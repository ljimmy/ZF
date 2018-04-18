<?php

namespace SF\Server;

use Swoole\Server;
use SF\Base\Config;
use SF\IoC\Container;
use SF\Events\EventManager;
use SF\Events\EventTypes;

class Application implements ServerInterface
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

        $app = $this->config->getApplication();

        if (isset($app['host'])) {
            $this->host = $app['host'];
        }
        if (isset($app['port'])) {
            $this->port = $app['port'];
        }
        if (isset($app['ssl'])) {
            $this->ssl = $app['ssl'];
        }
        if (isset($app['mode'])) {
            $this->mode = $app['mode'];
        }
        if (isset($app['sockType'])) {
            $this->sockType = $app['sockType'];
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

    protected function createServer()
    {
        return new Server($this->host, $this->port, $this->mode, $this->ssl ? $this->sockType | SWOOLE_SSL : $this->sockType);
    }

    public function start()
    {
        $this->server = $this->createServer();

        $this->server->set($this->config->getServer());
        $this->container->get(EventManager::class)->trigger(EventTypes::SERVER_INIT, $this->server);
        $this->container->get(EventManager::class)->trigger(EventTypes::BEFORE_START, $this->server);
        $this->server->start();
    }

    public function stop()
    {
        $this->server->shutdown();
    }

    public function reload()
    {
        $this->init();
        $this->server->reload();
    }


}
