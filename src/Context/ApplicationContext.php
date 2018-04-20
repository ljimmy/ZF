<?php

namespace SF\Context;

use Psr\Log\LoggerInterface;
use SF\Cache\CacheInterface;
use SF\Cache\CacheServiceProvider;
use SF\Contracts\Context\Context;
use SF\IoC\Container;
use SF\Log\LoggerFactory;
use Swoole\Server;

class ApplicationContext implements Context
{

    /**
     * @var self
     */
    private static $context;
    /**
     * @var Server
     */
    private $server;
    /**
     *
     * @var Container
     */
    private $container;
    /**
     *
     * @var CacheInterface
     */
    private $cache;
    /**
     * @var LoggerInterface;
     */
    private $logger;

    public function __construct(Container $container, Server $server)
    {
        $this->container = $container;
        $this->server    = $server;
    }

    /**
     *
     * @return $this
     */
    public static function getContext()
    {
        return self::$context;
    }

    public function enter()
    {
        self::$context = $this;
    }

    public function isTask(): bool
    {
        return $this->server->taskworker;
    }


    /**
     *
     * @return CacheInterface
     */
    public function getCache(): CacheInterface
    {
        if ($this->cache === null) {
            $this->cache = $this->getContainer()->get(CacheServiceProvider::class)->getCache();
        }
        return $this->cache;
    }

    public function setCache(CacheInterface $cache)
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * @return \SF\IoC\Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    public function getLogger(): LoggerInterface
    {
        if ($this->logger === null) {
            $this->logger = $this->getContainer()->get(LoggerFactory::class)->getLogger();
        }

        return $this->logger;
    }

    public function exitContext()
    {
        $this->server  = null;
        $this->cache   = null;
        $this->logger  = null;
        self::$context = null;
    }

}
