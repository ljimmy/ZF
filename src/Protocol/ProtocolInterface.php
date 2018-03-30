<?php

namespace SF\Protocol;

interface ProtocolInterface
{
    public function getVersion(): string;

    public function handle(string $data): ReplyInterface;
}