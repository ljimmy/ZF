<?php

namespace SF\Server;

use Swoole\Server;
use SF\Base\Config;
use SF\Di\Container;
use SF\Events\EventManager;

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
    protected $config = [];
    protected $server;

    /**
     *
     * @var \SF\Context\ApplicationContext
     */
    public $context;

    public function __construct(array $config = [])
    {
        $this->config = new Config($config);
        $this->container = new Container();
        $this->registerComponents($this->config->getComponents());
    }

    public function bootstrap(Server $server)
    {
        $this->server = $server;
    }

    protected function initContainer(array $components)
    {
        $defaultComponents = $this->getComponents();

        foreach ($components as $key => $value) {
            $defaultComponents[$key] = $value;
        }
        $this->container = new Container($defaultComponents);
    }

    protected function registerComponents(array $components)
    {
        $defaultComponents = $this->getComponents();
        foreach ($components as $alias => $component) {
            $defaultComponents[$alias] = $component;
        }
        $this->container->setDefinitions($defaultComponents);
        foreach ($defaultComponents as $alias => $component) {
            $this->container->get($component['class'] ?? $alias);
        }

    }

    public function registerEvents(array $events)
    {
        $eventManager = $this->container->get(EventManager::class);
        foreach ($events as $event) {
            $eventManager->attach(new $event($this), $this->getServer());
        }
    }

    protected function getComponents()
    {
        return [
            'EventManager' => [
                'class' => EventManager::class,
            ]
        ];
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
