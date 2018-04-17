<?php

namespace SF\Contracts\Event;


interface Event
{
    public function getType();

    public function handle();

}