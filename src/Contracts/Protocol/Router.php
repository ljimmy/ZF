<?php

namespace SF\Contracts\Protocol;


interface Router
{
    public function handle(Message $message): Action;
}