<?php

namespace SF\Contracts\Event;


interface Server
{
    public function getName(): string;

    public function getCallback(): \Closure;

}