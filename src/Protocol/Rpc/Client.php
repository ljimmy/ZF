<?php

namespace SF\Protocol\Rpc;

use SF\Contracts\Protocol\Client as ClientInterface;
use SF\Exceptions\Protocol\Rpc\RpcException;
use Swoole\Coroutine\Client as SwooleCoroutineClient;

class Client implements ClientInterface
{
    public $host;

    public $port;

    public $timeout;

    public $flag;


    protected $client;


    public function __construct()
    {
        $this->client = new SwooleCoroutineClient();

    }


    public function call(string $method, $data = '')
    {
        if ($this->client->connect($this->host, $this->port, $this->timeout) === false) {
            throw new RpcException($this->client->errCode, socket_strerror($this->client->errCode));
        }

        $this->client->send($data);
        $this->client->close();
    }

}