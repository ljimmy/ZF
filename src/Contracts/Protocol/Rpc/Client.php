<?php

namespace SF\Contracts\Protocol\Rpc;


interface Client
{
    public function call(string $method, ...$params);

}