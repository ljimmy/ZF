<?php

namespace SF\Cache;

use SF\IoC\Container;
use SF\Contracts\Store;
use SF\Contracts\IoC\Object;

class CacheServiceProvider implements Object
{

    const CACHE_DRIVER = 'cache_driver';

    public $driver;

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
        if ($this->driver === null) {
            throw new CacheException('the driver of cache is not exist!');
        }
        $this->container->setDefinition((array) $this->driver, self::CACHE_DRIVER);
    }

    public function getCache(): Store
    {
        return $this->container->get(self::CACHE_DRIVER);
    }

}
