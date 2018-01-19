<?php

namespace SF\Context;

use SF\Server\AbstractServer;
use SF\Cache\CacheInterface;
use SF\Cache\CacheServiceProvider;

class ApplicationContext
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
    private $logger;
    private static $context;

    public static function create()
    {

    }

    public function __construct(AbstractServer $application)
    {
        $server            = $application->getServer();
        $this->application = $application;
        $this->type        = $server->taskworker ? self::TASK : self::WORKER;
        $this->init();
        static::$context   = $this;
    }

    public function init()
    {
        $this->setProcessTitle();
        $this->application->context = $this;
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
    public function getCache()
    {
        if ($this->cache === null) {
            $this->cache = $this->getContainer()->get(CacheServiceProvider::class)->getCache();
        }
        return $this->cache;
    }

    public function getLogger()
    {
        return $this->logger;
    }

    /**
     *
     * @return $this
     */
    public static function getContext()
    {
        return static::$context;
    }

    public function destroy()
    {
        $this->application = null;
        $this->cache       = null;
        $this->logger      = null;
        static::$context   = null;
    }

}
