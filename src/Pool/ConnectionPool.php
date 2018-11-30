<?php

namespace SF\Pool;

use SF\Coroutine\Coroutine;
use SF\Contracts\Pool\Connector;
use SF\Exceptions\Pool\PoolException;

class ConnectionPool
{

    public $minimum = 0;

    /**
     * 每个进程最大连接数
     * @var int
     */
    public $maximum = 0;

    /**
     * 连接生成器
     * @var Connector
     */
    private $connector;

    /**
     * 闲置连接
     * @var \SplQueue
     */
    private $idling;


    /**
     * 等待
     * @var \SplQueue
     */
    private $waiting;
    /**
     * @var int
     */
    private $connected = 0;

    public function __construct(Connector $connector, int $minimum, int $maximum)
    {
        $this->connector = $connector;
        $this->minimum = $minimum;
        $this->maximum = $maximum;
        $this->idling = new \SplQueue();
        $this->waiting = new \SplQueue();
    }

    public function addConnection($connection = null): void
    {
        if ($connection === null) {
            $connection = $this->connector->connect();
        } else {
            $this->connected--;
        }

        if ($this->maximum && $this->idling->count() >= $this->maximum) {
            throw new PoolException('connections is exceed the maximum value[' . $this->maximum . ']');
        }

        if (!$this->waiting->isEmpty()) {
            $this->idling->enqueue($connection);
            Coroutine::resume($this->waiting->dequeue());
        } else if ($this->minimum && $this->idling->count() > $this->minimum) {
            unset($connection);
        } else {
            $this->idling->enqueue($connection);
        }
    }


    /**
     * @return PooledConnection
     * @throws PoolException
     */
    public function getConnection(): PooledConnection
    {
        if ($this->maximum && $this->connected >= $this->maximum) {
            $id = Coroutine::getuid();
            $this->waiting->enqueue($id);
            Coroutine::suspend($id);
        }

        if ($this->idling->isEmpty()) {
            $this->idling->enqueue($this->connector->connect());
        }

        $connection = $this->idling->dequeue();
        $this->connected++;
        return new PooledConnection($connection, $this);
    }
}
