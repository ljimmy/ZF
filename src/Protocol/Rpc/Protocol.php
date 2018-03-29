<?php

namespace SF\Protocol\Rpc;


use SF\Packer\Json;
use SF\Packer\PackerInterface;
use SF\Protocol\ProtocolInterface;
use SF\Protocol\ReceiveInterface;
use SF\Protocol\ReplyInterface;
use SF\Exceptions\UserException;

class Protocol implements ProtocolInterface
{
    public $version = '1.0';

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

    public function receive(string $data): ReceiveInterface
    {
        return new Receive($data);
    }

    public function reply(ReceiveInterface $receive): ReplyInterface
    {

    }


}