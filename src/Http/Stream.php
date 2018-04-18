<?php

namespace SF\Http;

use Psr\Http\Message\StreamInterface;

class Stream implements StreamInterface
{
    /**
     *
     * @var string
     */
    private $contents = '';

    /**
     *
     * @var int
     */
    private $size;

    public function __construct(string $contents)
    {
        $this->contents = $contents;
    }

    public function __toString(): string
    {
        return $this->getContents();
    }

    public function getContents(): string
    {
        return $this->contents;
    }

    public function close(): void
    {

    }

    public function detach()
    {

    }

    public function eof(): bool
    {

    }

    public function getMetadata($key = null)
    {

    }

    public function getSize()
    {
        if ($this->size === null) {
            $this->size = strlen($this->contents);
        }
        return $this->size;
    }

    public function isReadable(): bool
    {

    }

    public function isSeekable(): bool
    {

    }

    public function isWritable(): bool
    {

    }

    public function read($length): string
    {

    }

    public function rewind()
    {

    }

    public function seek($offset, $whence = SEEK_SET)
    {

    }

    public function tell(): int
    {

    }

    public function write($string): int
    {

    }
}