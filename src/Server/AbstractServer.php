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

    public function bootstrap(Server $server)
    {
        $this->server = $server;
        $this->container->get(EventManager::class)->trigger(EventTypes::SERVER_INIT, $server);
    }

    public function getContainer()
    {
        return $this->container;
    }

    public function getServer()
    {
        return $this->server;
    }

    abstract public function start();

    abstract public function stop();

    abstract public function reload();
}
