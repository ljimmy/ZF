<?php
namespace SF\Contracts\Protocol\Rpc;


use SF\Contracts\Protocol\Stream;

interface Body extends Stream
{
    public function getActionName();
}