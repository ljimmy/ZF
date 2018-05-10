<?php

namespace SF\Contracts\Event;


interface User
{
    public function getType();

    public function handle();

}