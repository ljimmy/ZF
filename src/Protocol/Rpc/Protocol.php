<?php

namespace SF\Protocol\Rpc;


use SF\Exceptions\UserException;
use SF\Packer\Json;
use SF\Packer\PackerInterface;
use SF\Protocol\ProtocolInterface;
use SF\Protocol\ReceiveInterface;
use SF\Protocol\ReplyInterface;

class Protocol implements ProtocolInterface
{
    public $type = self::TCP;

    public $version = '2.0';

    public $ssl = false;

    public $packer;

    public function init()
    {
        if ($this->packer === null) {
            $this->packer = Json::class;
        }

        if ($this->packer instanceof PackerInterface) {
            $this->packer = new $this->packer();
        } else {
            throw new UserException('packer must implement the interface SF\Packer\PackerInterface');
        }
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getType(): int
    {
        return self::TCP;
    }

    public function isSSL(): bool
    {
        return $this->ssl;
    }

    public function receive(string $data): ReceiveInterface
    {
        return new Receive($data);
    }

    public function reply(ReceiveInterface $receive): ReplyInterface
    {

    }


}