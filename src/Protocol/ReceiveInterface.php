<?php

namespace SF\Protocol;

use SF\Packer\PackerInterface;

interface ReceiveInterface
{
    public function unpack(PackerInterface $packer);
}