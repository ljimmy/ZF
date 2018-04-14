<?php

namespace SF\Contracts\Protocol;


interface Protocol extends Authenticator
{
    public function receive(string $data): Message;

    public function reply(Message $message): string;
}