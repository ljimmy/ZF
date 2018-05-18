<?php

namespace SF\Cache;

use SF\IoC\Container;
use SF\Contracts\IoC\Object;

class CacheServiceProvider implements Object
{

    public $drivers;

    /**
     *
     * @var Container
     */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function init()
    {
        $this->registerCacheServices($this->drivers);
    }

    public function registerCacheServices(array $drivers)
    {
        foreach ($drivers as $name => $driver) {
            CacheManager::registerDriver($name, $this->container->make($driver));
        }
    }


}
