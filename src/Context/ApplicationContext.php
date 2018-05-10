<?php

namespace SF\Context;

use Psr\Log\LoggerInterface;
use SF\Log\LoggerFactory;
use SF\Server\Application;
use SF\Cache\CacheInterface;
use SF\Cache\CacheServiceProvider;
use SF\Contracts\Context\Context;

class ApplicationContext implements Context
{

    /**
     * @var self
     */
    private static $context;

    /**
     *
     * @var CacheInterface
     */
    private $cache;

    /**
     * @var LoggerInterface;
     */
    private $logger;

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
        return Application::getApp()->getServer()->taskworker;
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

    public function getLogger(): LoggerInterface
    {
        if ($this->logger === null) {
            $this->logger = $this->getContainer()->get(LoggerFactory::class)->getLogger();
        }

        return $this->logger;
    }

    /**
     * @return \SF\IoC\Container
     */
    public function getContainer()
    {
        return Application::getApp()->getContainer();
    }

    public function exitContext()
    {
        $this->cache   = null;
        $this->logger  = null;
        self::$context = null;
    }

}
