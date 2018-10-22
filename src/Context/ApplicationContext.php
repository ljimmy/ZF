<?php

namespace SF\Context;

use Psr\Log\LoggerInterface;
use SF\Cache\CacheManager;
use SF\Log\LoggerFactory;
use SF\Server\Application;
use SF\Contracts\Context\Context;
use SF\Contracts\Cache\Repository;

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
     * @param string|null $name
     * @return Repository
     */
    public function getCache(string $name = null): Repository
    {
        if ($this->cache === null) {
            $this->cache = CacheManager::getDriver($name === null ? CacheManager::getDefaultDriverName() : $name);
        }
        return $this->cache;
    }

    public function setCache(Repository $cache)
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

    public function getApp()
    {
        return Application::getApp();
    }

    public function exitContext()
    {
        $this->cache   = null;
        $this->logger  = null;
        self::$context = null;
    }

}
