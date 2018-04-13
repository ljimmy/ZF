<?php

namespace SF\Protocol\Rpc;

use SF\Contracts\Packer\Packer;
use SF\Contracts\Protocol\Authenticator as AuthenticatorInterface;
use SF\Contracts\Protocol\Protocol as ProtocolInterface;
use SF\Contracts\Protocol\Receiver as ReceiverInterface;
use SF\Contracts\Protocol\Replier as ReplierInterface;
use SF\Di\Container;
use SF\Exceptions\UserException;
use SF\Packer\Json;

class Protocol implements ProtocolInterface
{
    const RPC_VERSION = 2;

    public $version = '1.0';

    /**
     * @var ReceiverInterface
     */
    public $receiver = Receiver::class;

    /**
     * @var ReplierInterface
     */
    public $replier = Replier::class;

    /**
     * @var Message
     */
    public $message = Message::class;

    /**
     * @var Packer
     */
    public $packer = Json::class;

    /**
     * @var \SF\Contracts\Protocol\Authenticator
     */
    public $authenticator = Authenticator::class;

    /**
     * @var Container
     */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function init()
    {
        if ($this->packer) {
            $this->packer = $this->container->setDefinition($this->packer, self::PACKER, true);
        }

        if (!$this->packer instanceof Packer) {
            throw new UserException('packer must implement the interface SF\Contracts\Packer\Packer');
        }

    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function handle(string $data): ReceiverInterface
    {
        return $this->container->get($this->receiver)->receive($data);
    }

    public function getReplier(): ReplierInterface
    {
        return $this->container->get($this->replier);
    }

    public function getAuthenticator(): AuthenticatorInterface
    {
        return $this->container->get($this->authenticator);
    }


}