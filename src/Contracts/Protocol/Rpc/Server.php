<?php

namespace SF\Contracts\Protocol\Rpc;

use SF\Contracts\Protocol\Message;

interface Server
{
    public function receive(string $data): Message;

    public function reply(Message $message): string;

}