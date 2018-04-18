<?php
/**
 * Created by PhpStorm.
 * User: xfb_user
 * Date: 2018/4/18
 * Time: 下午6:04
 */

namespace SF\WebSocket;

use SF\Http\Application as Http;
use Swoole\WebSocket\Server;

class Application extends Http
{
    protected function createServer()
    {
        return new Server($this->host, $this->port, $this->mode, $this->ssl ? $this->sockType | SWOOLE_SSL : $this->sockType);
    }
}