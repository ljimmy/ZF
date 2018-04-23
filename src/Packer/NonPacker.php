<?php

namespace SF\Packer;


use SF\Contracts\Packer\Packer;

class NonPacker implements Packer
{
    public function pack($data)
    {
        return $data;
    }

    public function unpack($data)
    {
        return $data;
    }


}