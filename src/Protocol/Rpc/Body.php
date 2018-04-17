<?php
namespace SF\Protocol\Rpc;


use SF\Contracts\Protocol\Stream;

class Body implements Stream
{
    public function __toString()
    {
        return '';
    }

    public function read(int $length): string
    {
        // TODO: Implement read() method.
    }

    public function write(string $contents)
    {
        // TODO: Implement write() method.
    }

    public function eof(): bool
    {
        // TODO: Implement eof() method.
    }

    public function getSize(): int
    {
        // TODO: Implement getSize() method.
    }

    public function getContents(): string
    {
        // TODO: Implement getContents() method.
    }




}