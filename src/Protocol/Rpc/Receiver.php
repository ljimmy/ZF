<?php

namespace SF\Protocol\Rpc;

use SF\Protocol\Stream;
use SF\Contracts\Protocol\Message as MessageInterface;
use SF\Contracts\Protocol\Receiver as ReceiverInterface;

class Receiver extends Message implements ReceiverInterface
{
    public function receive(string $data): MessageInterface
    {
        $this->header = (new Header())->load($data);
        $this->stream = new Stream(substr($data, Header::HEADER_LENGTH));

        return $this;
    }


}