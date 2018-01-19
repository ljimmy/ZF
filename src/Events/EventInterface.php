<?php

namespace SF\Events;

interface EventInterface
{
    public function on($target);

    public function callback();
}
