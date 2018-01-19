<?php

namespace SF\Pool;

use SF\Coroutine\Coroutine;

abstract class AbstractPool implements PoolInterface
{
    /**
     * 每个进程最大连接数
     * @var int
     */
    public $maxConnections = 0;

    /**
     * 连接数
     * @var int
     */
    private $connected = 0;

    /**
     * 连接
     * @var \SplQueue
     */
    private $connectors;

    /**
     * 挂起
     * @var \SplQueue
     */
    private $suspend;

    public function __construct()
    {
        $this->connectors = new \SplQueue();
        $this->suspend    = new \SplQueue();
    }

    /**
     * @return mixed
     */
    public function get()
    {
        if ($this->maxConnections > 0 && $this->connected > $this->maxConnections) {
            $id = Coroutine::getuid();
            $this->suspend->enqueue($id);
            Coroutine::suspend($id);
        }

        if ($this->connectors->isEmpty()) {
            $this->connectors->enqueue($this->createConnector());
        }

        $connector = $this->connectors->dequeue();
        $this->connected++;
        return $connector;
    }

    public function release($connector)
    {
        $this->connected--;
        $this->connectors->enqueue($connector);
        if (!$this->suspend->isEmpty()) {
            Coroutine::resume($this->suspend->dequeue());
        }
    }

    abstract protected function createConnector();
}
