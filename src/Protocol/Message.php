<?php

namespace SF\Protocol;

use SF\Contracts\Protocol\Message as MessageInterface;
use SF\Contracts\Protocol\Stream as StreamInterface;
use SF\Support\Collection;

class Message implements MessageInterface
{
    /**
     * @var Header
     */
    protected $header;

    /**
     * @var Stream
     */
    protected $stream;

    public function getHeader(): Collection
    {
        return $this->header;
    }

    public function withHeader(Collection $header)
    {
        $this->header = $header;
    }

    public function getStream(): StreamInterface
    {
        return $this->stream;
    }

    public function withStream(StreamInterface $stream)
    {
        $this->stream = $stream;
    }


}