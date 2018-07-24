<?php

namespace SF\Client;

use SF\Contracts\Event\Server as ServerEvent;
use Swoole\Client;

class Application
{
    public $async = true;

    public $socketType = SWOOLE_SOCK_TCP;

    private $settings;

    private $connectionKey;

    private $client;

    public function __construct(array $settings = [], string $connectionKey = '')
    {
        $this->settings = $settings;
        $this->connectionKey = $connectionKey;
    }

    public function getClint(): Client
    {
        if ($this->client === null) {
            $this->client = new Client($this->socketType, $this->async, $this->connectionKey);
            $this->client->set($this->settings);
        }

        return $this->client;
    }

    public function bindEvent(ServerEvent $event)
    {
        if ($this->async) {
            $this->getClint()->on($event->getName(), $event->getCallback());
        }
    }




}
