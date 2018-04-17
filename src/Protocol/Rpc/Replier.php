<?php

namespace SF\Protocol\Rpc;


use SF\Contracts\Protocol\Message as MessageInterface;
use SF\Protocol\Message;

class Replier extends Message implements ReplierInterface
{

    public function reply(MessageInterface $message): string
    {
        $stream = $message->getStream();
        $header = $message->getHeader();

        $header->length = $stream->getSize();


        return pack(
                'JNnnJ',
                $header['id'],
                $header['length'],
                $header['version'],
                $header['flavor'],
                $header['credential']
            )
            . $stream->getContents();
    }


}