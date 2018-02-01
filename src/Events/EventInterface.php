<?php

namespace SF\Events;

interface EventInterface
{
    public function getType();

    public function handle();
}
