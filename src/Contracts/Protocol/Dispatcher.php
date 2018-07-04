<?php

namespace SF\Contracts\Protocol;

interface Dispatcher
{

    public function dispatch(Message $message, Router $router);
}