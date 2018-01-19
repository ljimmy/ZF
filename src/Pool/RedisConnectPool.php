<?php

namespace SF\Pool;

use SF\Redis\RedisCache;

class RedisConnectPool extends AbstractPool
{
    /**
     *
     * @var RedisCache
     */
    private $redis;

    public function __construct(RedisCache $redis, int $maxConnections)
    {
        $this->redis = $redis;
        $this->maxConnections = $maxConnections;
        parent::__construct();
    }

    protected function createConnector()
    {
        return $this->redis->getConnector();
    }

}
