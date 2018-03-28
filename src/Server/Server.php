<?php
/**
 * Created by PhpStorm.
 * User: xfb_user
 * Date: 2018/3/28
 * Time: 下午7:34
 */

namespace SF\Server;


class Server extends AbstractServer
{
    protected function createServer()
    {
        return new \Swoole\Server($this->host, $this->port, $this->mode, $this->ssl ? $this->sockType | SWOOLE_SSL : $this->sockType);
    }

    public function stop()
    {
        // TODO: Implement stop() method.
    }

    public function reload()
    {
        // TODO: Implement reload() method.
    }


}