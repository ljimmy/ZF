<?php

namespace SF\Client;

use Swoole\Http\Client;

class Http
{

    private $client;

    public function __construct(string $destination, int $port = null, bool $ssl = false)
    {
        if ($port === null) {
            $port = $ssl ? 443 : 80;
        }

        $this->client = new Client($destination, $port);
    }

    public function setting(array $setting)
    {
        $this->client->set($setting);

        return $this;
    }

    public function setHeaders(array $headers)
    {
        $this->client->setHeaders($headers);

        return $this;
    }

    public function setCookies(array $cookies)
    {
        $this->client->setCookies($cookies);

        return $this;
    }

    public function request(string $method, string $path, $data, callable $callback)
    {
        $method = strtoupper($method);
        $this->client->setMethod($method);

        if ($method == 'GET' || $method == 'DELETE') {
            $this->client->get($path, $callback);
        } else {
            $this->client->post($path, $data, $callback);
        }
    }

}