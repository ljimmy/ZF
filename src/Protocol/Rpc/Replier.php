<?php

namespace SF\Protocol\Rpc;

use SF\Contracts\Protocol\Replier as ReplierInterface;

class Replier implements ReplierInterface
{

    protected $protocol;

    protected $receiver;

    public function __construct(Protocol $protocol, Receiver $receiver = null)
    {
        $this->protocol = $protocol;
        $this->receiver  = $receiver;
    }

    /**
     *
     * @param Message|string $message
     * @return string
     */
    public function pack($message): string
    {
        $request = $this->receiver->getMessage();

        if (! $message instanceof Message) {
            $message = new Message(
                            new Header(
                                [
                                    'id'      => $request->getPackageHeader('id'),
                                    'length'  => $request->getPackageHeader('length'),
                                    'version' => $request->getPackageHeader('version'),
                                    'flavor'  => $request->getPackageHeader('flavor'),
                                ]
                            ),
                            $message
                        );
        }


        return pack(
                'JNnnJ',
                $message->getPackageHeader('id'),
                $message->getPackageHeader('length'),
                $message->getPackageHeader('version'),
                $message->getPackageHeader('flavor'),
                $this->protocol->getAuthenticator()->generate($message)
            ) .
            $this->protocol->getPacker()->pack($message->getPackageBody());
    }

}
