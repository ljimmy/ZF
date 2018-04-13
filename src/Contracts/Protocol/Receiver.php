<?php

namespace SF\Contracts\Protocol;


interface Receiver
{
    public function receive(string $data): Message;

}