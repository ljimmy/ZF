<?php

namespace SF\Contracts\Packer;


interface Packer
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