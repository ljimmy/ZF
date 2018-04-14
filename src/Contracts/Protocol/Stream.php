<?php

namespace SF\Contracts\Protocol;


interface Stream
{
    public function __toString();

    public function read(int $length): string;

    public function write(string $contents);

    public function eof(): bool;

    public function getSize(): int;

    public function getContents(): string;
}