<?php

namespace SF\Protocol\Rpc;

use SF\Di\Container;
use SF\Exceptions\UserException;
use SF\Packer\Json;
use SF\Packer\PackerInterface;
use SF\Protocol\ProtocolInterface;
use SF\Protocol\ReceiverInterface;
use SF\Protocol\ReplierInterface;

class Protocol implements ProtocolInterface
{
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

        if ($this->receiver) {
            $this->receiver = $this->container->setDefinition($this->receiver, null, true);
        }

        if ($this->replier) {
            $this->replier = $this->container->setDefinition($this->replier, null, true);
        }

    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getReceiver(): ReceiverInterface
    {
        return $this->receiver;
    }

    public function getReplier(): ReplierInterface
    {
        return $this->replier;
    }


}