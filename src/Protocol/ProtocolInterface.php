<?php

namespace SF\Protocol;

interface ProtocolInterface
{
    public function getVersion(): string;

    public function receive(string $data): ReceiveInterface;

    public function reply(ReceiveInterface $receive): ReplyInterface;
}