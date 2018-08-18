<?php

namespace SF\Cache;

use SF\Contracts\Cache\Repository as RepositoryInterface;
use SF\Exceptions\Cache\CacheException;
use SF\Redis\Client;

class Redis implements RepositoryInterface
{

    /**
     *
     * @var string
     */
    public $host;

    /**
     *
     * @var int
     */
    public $port;

    /**
     *
     * @var int
     */
    public $timeout;

    /**
     *
     * @var string
     */
    public $auth;

    /**
     *
     * @var int
     */
    public $database = 0;

    /**
     *
     * @var bool
     */
    public $serialize = false;

    /**
     * @var Client
     */
    protected $client;


    public function get($key, $default = null)
    {
        $value = $this->getDriver()->get($key);
        return $value === false || $value === null ? $default : $value;
    }

    public function set($key, $value, $ttl = null)
    {
        return $ttl > 0 ? $this->getDriver()->set($key, $value, (int)$ttl) : $this->getDriver()->set($key, $value);
    }

    public function delete($key)
    {
        return $this->getDriver()->del($key);
    }

    public function clear()
    {
        return $this->getDriver()->flushdb();
    }

    public function getMultiple($keys, $default = null)
    {
        $result = $this->getDriver()->mget($keys);

        return $result === false ? $default : $result;
    }

    public function setMultiple($values, $ttl = null)
    {
        $client = $this->getDriver();
        $ttl = (int)$ttl;
        if ($ttl > 0) {
            $client->multi();
            foreach ($values as $key => $value) {
                $client->set($key, $value, $ttl);
            }
            return $client->exec();
        } else {
            return $client->mset($values);
        }
    }

    public function deleteMultiple($keys)
    {
        return $this->getDriver()->del($keys);
    }

    public function has($key)
    {
        return $this->getDriver()->exists($key);
    }

    public function getDriver()
    {
        if ($this->client === null) {
            $this->client = new Client(['timeout' => (int)$this->timeout]);
            if ($this->client->connect($this->host, $this->port, $this->serialize) === false) {
                throw new CacheException('connect failed.');
            }
            if ($this->auth) {
                $this->client->auth($this->auth);
            }
            if ($this->database) {
                $this->client->select($this->database);
            }
        }

        return $this->client;
    }


}
