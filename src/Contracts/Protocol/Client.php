<?php

namespace SF\Contracts\Protocol;


interface Client
{
    public function call(string $method, $data);
}