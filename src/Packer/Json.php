<?php

namespace SF\Packer;

use SF\Support\Json as JsonSupport;

class Json implements PackerInterface
{
    public function pack($data)
    {
        return JsonSupport::enCode($data);
    }

    public function unpack($data)
    {
        return JsonSupport::deCode($data, true);
    }

}