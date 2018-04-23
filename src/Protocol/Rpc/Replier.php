<?php

namespace SF\Protocol\Rpc;

use SF\Contracts\Protocol\Replier as ReplierInterface;

class Replier implements ReplierInterface
{
    protected $protocol;

    public function __construct(Protocol $protocol)
    {
        $this->protocol = $protocol;
    }

    public function pack(Message $message = null): string
    {
        if ($message === null) {
            return '';
        }

    }


}