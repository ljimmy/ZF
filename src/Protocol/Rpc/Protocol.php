<?php

namespace SF\Protocol\Rpc;

use SF\Contracts\Protocol\Message;
use SF\Contracts\Protocol\Protocol as ProtocolInterface;
use SF\Contracts\Protocol\Receiver as ReceiverInterface;
use SF\Contracts\Protocol\Replier as ReplierInterface;
use SF\Contracts\Protocol\Authenticator as AuthenticatorInterface;
use SF\Protocol\Rpc\Exceptions\Denied\RpcMisMatchException;
use SF\Protocol\Rpc\Exceptions\RpcException;

class Protocol implements ProtocolInterface
{
    /**
     * low version
     * @var int
     */
    public $low;

    /**
     * high version
     * @var int
     */
    public $high;

    /**
     * @var ReceiverInterface
     */
    public $receiver = Receiver::class;

    /**
     * @var ReplierInterface
     */
    public $replier = Replier::class;

    /**
     * @var Authenticator
     */
    public $authenticator = Authenticator::class;


    public function init()
    {
        $this->receiver = new $this->receiver;
        $this->replier = new $this->replier;
        $this->authenticator = new $this->authenticator;

        if (! $this->receiver instanceof ReceiverInterface) {
            throw new RpcException('Receiver must implement the interface SF\Contracts\Protocol\Receiver');
        }

        if (! $this->replier instanceof ReplierInterface) {
            throw new RpcException('Replier must implement the interface SF\Contracts\Protocol\Replier');
        }

        if (!$this->authenticator instanceof AuthenticatorInterface) {
            throw new RpcException('Authenticator must implement the interface SF\Contracts\Protocol\Authenticator');
        }

    }

    public function receive(string $data): Message
    {
        $message =  $this->receiver->unpack($data);
        $this->validate($message);

        return $message;
    }

    public function reply(Message $message): string
    {
        return $this->replier->pack($message);
    }

    public function validate(Message $message)
    {
        $version = $message->getHeader()->get('version');
        if ($this->low !== null && $version < $this->low) {
            throw new RpcMisMatchException($this->low, $this->high);
        }

        if ($this->high !== null && $version > $this->high) {
            throw new RpcMisMatchException($this->low, $this->high);
        }

        return $this->authenticator->validate($message);
    }

    public function generate(Message $message): string
    {
        return $this->authenticator->generate($message);
    }


}