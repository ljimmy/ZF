<?php

namespace SF\Context;

use SF\Server\AbstractServer;
use SF\Cache\CacheInterface;
use SF\Cache\CacheServiceProvider;
use SF\Log\LoggerFactory;
use Psr\Log\LoggerInterface;

class ApplicationContext implements  InterfaceContext
{

    const WORKER = 1;

    const TASK   = 1;

    /**
     *
     * @var 应用类型
     */
    private $type;

    /**
     *
     * @var AbstractServer
     */
    private $application;

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
     * @var self
     */
    private static $context;

    public function __construct(AbstractServer $application)
    {
        $this->application = $application;
    }

    public function enter()
    {
        $server            = $this->application->getServer();
        $this->type        = $server->taskworker ? self::TASK : self::WORKER;
        $this->application->context = $this;

        $this->setProcessTitle();
        self::$context   = $this;
    }

    public function setProcessTitle()
    {
        $title = '';
        switch ($this->type) {
            case self::WORKER:
                $title = 'SF Worker Process';
                break;
            case self::TASK:
                $title = 'SF Task Process';
                break;
        }
        setProcessTitle($title);
    }

    public function getApplication()
    {
        return $this->application;
    }

    /**
     * @return \SF\Di\Container
     */
    public function getContainer()
    {
        return $this->application->getContainer();
    }

    public function setCache(CacheInterface $cache)
    {
        $this->cache = $cache;

        return $this;
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

    public function getLogger(): LoggerInterface
    {
        if ($this->logger === null) {
            $this->logger = $this->getContainer()->get(LoggerFactory::class)->getLogger();
        }

        return $this->logger;
    }

    /**
     *
     * @return $this
     */
    public static function getContext()
    {
        return self::$context;
    }

    public function exitContext()
    {
        $this->application = null;
        $this->cache       = null;
        $this->logger      = null;
        self::$context   = null;
    }

}
