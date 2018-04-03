<?php

namespace SF\Protocol;

interface ReceiverInterface
{
    public function receive(string $data): Message;
}