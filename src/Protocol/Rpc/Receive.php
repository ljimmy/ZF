<?php
namespace SF\Protocol\Rpc;

use SF\Packer\PackerInterface;
use SF\Protocol\ReceiveInterface;

class Receive implements ReceiveInterface
{
    private $data;

    public function __construct(string $data)
    {
        $this->data = $data;
    }

    public function unpack(PackerInterface $packer)
    {
        return $packer->unpack($this->data);
    }


}