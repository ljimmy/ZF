<?php

namespace SF\Protocol;

use SF\Contracts\Protocol\Stream as StreamInterface;

class Stream implements StreamInterface
{

    /**
     * @var string
     */
    private $contents;

    /**
     * @var int
     */
    private $position = 0;


    public function __construct(string $contents)
    {
        $this->contents = $contents;
    }

    public function __toString()
    {
        return $this->getContents();
    }

    public function getContents(): string
    {
        return $this->contents;
    }


    public function read(int $length): string
    {
        $contents = substr($this->contents, $this->position, $length);

        $this->position += $length;

        return (string)$contents;
    }

    public function write(string $contents)
    {
        $this->contents .= $contents;

        return $this;
    }

    public function eof(): bool
    {
        return $this->position >= strlen($this->contents);
    }

    public function getSize(): int
    {
        return strlen($this->contents);
    }


}