<?php

namespace SF\Packer;


interface PackerInterface
{
    /**
     * @param $data
     * @return mixed
     */
    public function pack($data);

    /**
     * @param $data
     * @return mixed
     */
    public function unpack($data);

}