<?php

namespace SF\Protocol;

interface ProtocolInterface
{
    const TCP = 6;

    const UDP = 17;

    public function getVersion(): string;

    public function getType(): int;

    public function isSSL():bool;

    public function receive(string $data): ReceiveInterface;

    public function reply(ReceiveInterface $receive): ReplyInterface;
}