<?php

namespace SF\Protocol;

use SF\Packer\PackerInterface;

interface ReplyInterface
{
    public function pack(PackerInterface $packer);
}