<?php

namespace SF\Protocol\Rpc;

use SF\Di\Container;
use SF\Exceptions\UserException;
use SF\Packer\Json;
use SF\Packer\PackerInterface;
use SF\Protocol\AuthenticatorInterface;
use SF\Protocol\ProtocolInterface;
use SF\Protocol\ReceiverInterface;
use SF\Protocol\ReplierInterface;

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
     * @var PackerInterface
     */
    public $packer = Json::class;

    /**
     * @var AuthenticatorInterface
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

        if (!$this->packer instanceof PackerInterface) {
            throw new UserException('packer must implement the interface SF\Packer\PackerInterface');
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