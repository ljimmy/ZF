<?php

namespace SF\Server;


interface ServerInterface
{

    public function start();

    public function stop();

    public function reload();

}